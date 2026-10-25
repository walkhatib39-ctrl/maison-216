<?php
// Private export helpers. Called only after the existing token check.
function m216Path(array $file): ?string {
    $relative = $file['path'] ?? '';
    if (!is_string($relative) || !str_starts_with($relative, 'lead-attachments/') || str_contains($relative, '..') || str_contains($relative, '\\')) return null;
    foreach ([__DIR__.'/../../storage/app/private', __DIR__.'/../../storage/app'] as $base) {
        $root = realpath($base.'/lead-attachments'); $path = realpath($base.'/'.$relative);
        if ($root && $path && str_starts_with($path, $root.DIRECTORY_SEPARATOR) && is_file($path)) return $path;
    }
    return null;
}
function m216Documents(array $payload): array {
    $out = [];
    foreach (($payload['attachments'] ?? []) as $i => $file) {
        if (!is_array($file)) continue;
        $path = m216Path($file);
        $out[] = ['id'=>'m-'.(int)$i, 'name'=>$file['name'] ?? 'Document', 'mime'=>$path ? (new finfo(FILEINFO_MIME_TYPE))->file($path) : ($file['mime'] ?? 'application/octet-stream'), 'size'=>$path ? filesize($path) : ($file['size'] ?? 0), 'available'=>(bool)$path];
    }
    return $out;
}
function m216Document(PDO $pdo): never {
    $id = filter_var($_GET['lead'] ?? '', FILTER_VALIDATE_INT);
    if (!$id || !preg_match('/^m-(\d+)$/D', $_GET['document'] ?? '', $match)) { http_response_code(400); exit; }
    $q=$pdo->prepare('SELECT payload FROM leads WHERE id=?'); $q->execute([$id]);
    $payload=json_decode($q->fetchColumn() ?: '{}',true) ?: [];
    $file=$payload['attachments'][(int)$match[1]] ?? null;
    $path=is_array($file) ? m216Path($file) : null;
    if (!$path) { http_response_code(404); exit; }
    if (filesize($path)>25*1024*1024) { http_response_code(413); exit; }
    $mime=(new finfo(FILEINFO_MIME_TYPE))->file($path);
    $name=preg_replace('/[\r\n\\\\\/]/','_', $file['name'] ?? 'document');
    if (($_GET['preview'] ?? '')==='1' && (str_contains($mime,'hei') || preg_match('/\.hei[cf]$/i',$name))) {
        try {
            Imagick::setResourceLimit(Imagick::RESOURCETYPE_MEMORY,128*1024*1024);
            Imagick::setResourceLimit(Imagick::RESOURCETYPE_MAP,256*1024*1024);
            $img=new Imagick(); $img->readImage($path.'[0]'); $img->autoOrient(); $img->thumbnailImage(1600,1600,true); $img->setImageFormat('jpeg'); $img->setImageCompressionQuality(85);
            header('Content-Type: image/jpeg'); header('Content-Disposition: inline'); echo $img->getImageBlob(); $img->clear(); exit;
        } catch (Throwable $e) { http_response_code(422); echo json_encode(['error'=>'preview_unavailable']); exit; }
    }
    $inline=in_array($mime,['application/pdf','image/jpeg','image/png','image/webp','image/gif'],true);
    header('Content-Type: '.($inline?$mime:'application/octet-stream'));
    header("Content-Disposition: ".($inline?'inline':'attachment')."; filename*=UTF-8''".rawurlencode($name));
    header('Content-Length: '.filesize($path)); readfile($path); exit;
}
function m216Export(PDO $pdo): array {
    $rows=$pdo->query('SELECT id,created_at,name,email,phone,city,subject,message,type,payload,source_url,status,company FROM leads ORDER BY id DESC LIMIT 5000')->fetchAll(PDO::FETCH_ASSOC);
    return array_map(function($r) {
        $p=json_decode($r['payload'] ?: '{}',true) ?: []; $message=$r['message'] ?? ''; $inspiration=[];
        foreach (['Ouvrage / inspiration'=>'category','Référence'=>'url','Préférences'=>'preferences','Inspiration'=>'title','Visuel'=>'image'] as $label=>$key) {
            if (preg_match('/^'.preg_quote($label,'/').'\s*:\s*(.+)$/mu',$message,$m)) $inspiration[$key]=trim($m[1]);
        }
        $links=[]; if(preg_match_all('~https?://[^\s<>]+~u',$message,$matches)) $links=array_values(array_unique($matches[0]));
        $dimensions=$p['dimensions'] ?? null;
        if (!$dimensions && preg_match('/\d+(?:[.,]\d+)?\s*(?:cm|m|mm)?\s*[*x×]\s*\d+(?:[.,]\d+)?\s*(?:cm|m|mm)?/iu',$message,$m)) $dimensions=trim($m[0]);
        $raw=['origin'=>'maison216-v1','source_id'=>(int)$r['id'],'source_url'=>$r['source_url'],'source_status'=>$r['status'],'company'=>$r['company'],'dimensions'=>$dimensions,'deadline'=>$p['deadline']??null,'project_type'=>$p['project_type']??null,'inspiration'=>$inspiration,'links'=>$links,'documents'=>m216Documents($p),'original_message'=>$message];
        $raw['source_revision']=hash('sha256',json_encode([$raw,$r['subject'],$r['city'],$r['name'],$r['phone'],$r['email']],JSON_UNESCAPED_UNICODE));
        return ['external_id'=>(string)$r['id'],'created_at'=>$r['created_at'],'nom'=>$r['name'],'email'=>$r['email'],'telephone'=>$r['phone'],'ville'=>$r['city'] ?: ($p['location']??''),'departement'=>'','service'=>$r['subject'],'message'=>$message,'type'=>$r['type'],'raw'=>$raw];
    },$rows);
}

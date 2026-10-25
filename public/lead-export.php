<?php
/**
 * Lead export (lecture seule) pour Leads Central — Maison216
 * À déposer dans public/lead-export.php
 */
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: private, no-store');

$TOKEN = trim((string) @file_get_contents(__DIR__.'/../storage/app/private/leadscentral-export-token'));

$hdr = $_SERVER['HTTP_AUTHORIZATION'] ?? ($_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '');
$bearer = preg_match('/Bearer\s+(.+)/i', $hdr, $m) ? trim($m[1]) : ($_GET['token'] ?? '');
if (!$TOKEN || !hash_equals($TOKEN, (string)$bearer)) {
    http_response_code(401);
    echo json_encode(['error' => 'unauthorized']);
    exit;
}

$env = @file_get_contents(__DIR__ . '/../.env');
function envv($env, $k, $d = '') {
    if ($env && preg_match('/^' . preg_quote($k, '/') . '=("?)(.*?)\1\s*$/m', $env, $mm)) return $mm[2];
    return $d;
}
try {
    $pdo = new PDO(
        'mysql:host=' . envv($env, 'DB_HOST', '127.0.0.1') . ';port=' . envv($env, 'DB_PORT', '3306') .
        ';dbname=' . envv($env, 'DB_DATABASE') . ';charset=utf8mb4',
        envv($env, 'DB_USERNAME'), envv($env, 'DB_PASSWORD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'db']);
    exit;
}

header('Cache-Control: private, no-store');
header('X-Content-Type-Options: nosniff');
header('X-Robots-Tag: noindex, nofollow');
require __DIR__.'/../app/Support/MaisonLeadExport.php';
if (isset($_GET['document'])) m216Document($pdo);
echo json_encode(m216Export($pdo), JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

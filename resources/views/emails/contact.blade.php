<!-- Email — Nouveau message de contact -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Nouveau message de contact — Maison 216</title>
  <style>
    body { font-family: Arial, sans-serif; color:#0f172a; }
    .card { max-width:640px; margin:0 auto; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden; }
    .head { background:#0f172a; color:#fff; padding:16px 20px; }
    .content { padding:20px; }
    .row { margin-bottom:10px; }
    .label { font-size:12px; color:#64748b; text-transform:uppercase; letter-spacing:.06em; }
    .value { font-size:14px; font-weight:700; color:#0f172a; }
    .box { background:#f8fafc; border:1px solid #e5e7eb; padding:12px; border-radius:8px; }
    .muted { color:#64748b; font-size:12px; }
  </style>
</head>
<body>
  <div class="card">
    <div class="head">
      <h1 style="margin:0;font-size:18px;">Nouveau message de contact</h1>
      <div style="font-size:12px;opacity:.8;">{{ \App\Models\Setting::get('site.name', 'Maison 216') }}</div>
    </div>
    <div class="content">
      <div class="row">
        <div class="label">Nom</div>
        <div class="value">{{ $name }}</div>
      </div>
      @if(!empty($email))
      <div class="row">
        <div class="label">Email</div>
        <div class="value">{{ $email }}</div>
      </div>
      @endif
      @if(!empty($phone))
      <div class="row">
        <div class="label">Téléphone</div>
        <div class="value">{{ $phone }}</div>
      </div>
      @endif
      @if(!empty($subjectLine))
      <div class="row">
        <div class="label">Objet</div>
        <div class="value">{{ $subjectLine }}</div>
      </div>
      @endif
      @if(!empty($company))
      <div class="row">
        <div class="label">Entreprise / Cabinet</div>
        <div class="value">{{ $company }}</div>
      </div>
      @endif
      @if(!empty($profession))
      <div class="row">
        <div class="label">Profession</div>
        <div class="value">{{ $profession }}</div>
      </div>
      @endif
      @if(!empty($location))
      <div class="row">
        <div class="label">Localisation</div>
        <div class="value">{{ $location }}</div>
      </div>
      @endif
      @if(!empty($hasProject))
      <div class="row">
        <div class="label">Projet en cours à chiffrer</div>
        <div class="value">{{ $hasProject }}</div>
      </div>
      @endif
      @if(!empty($projectType))
      <div class="row">
        <div class="label">Type de projets</div>
        <div class="box">
          <div style="white-space:pre-wrap;">{{ $projectType }}</div>
        </div>
      </div>
      @endif

      <div class="row">
        <div class="label">Message</div>
        <div class="box">
          <div style="white-space:pre-wrap;">{{ $messageBody }}</div>
        </div>
      </div>

      <div class="row muted">
        <div>IP: {{ $ip }} • Navigateur: {{ $ua }}</div>
      </div>
    </div>
  </div>
</body>
</html>

<!-- 500 — Maison 216 -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Erreur serveur — Maison 216</title>
  <meta name="robots" content="noindex,follow">
  <style>
    :root{--primary:#7c5c2d;--dark:#0f172a}
    *{box-sizing:border-box}html,body{height:100%}
    body{margin:0;min-height:100%;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans,sans-serif;color:#0b1220;background:#fff}
    .wrap{min-height:100%;display:flex;align-items:center;justify-content:center;padding:24px}
    .card{width:100%;max-width:920px;border:1px solid #e5e7eb;border-radius:20px;overflow:hidden;box-shadow:0 10px 30px rgba(15,23,42,.08)}
    .top{position:relative;padding:40px;border-bottom:1px solid #f1f5f9;background:
      radial-gradient(1200px 400px at 0% -10%, rgba(124,92,45,.12), transparent 60%),
      radial-gradient(1000px 300px at 100% 0%, rgba(124,92,45,.08), transparent 60%);}
    .badge{display:inline-flex;gap:10px;align-items:center;padding:8px 14px;border-radius:999px;background:rgba(124,92,45,.08);color:#6b4f28;font-weight:600;font-size:12px}
    .title{margin:18px 0 8px;font-size:32px;line-height:1.15;color:var(--dark);font-weight:900;letter-spacing:-.02em}
    .desc{margin:0;color:#475569}
    .content{padding:28px 40px;display:grid;grid-template-columns:1fr;gap:22px}
    @media(min-width:860px){.content{grid-template-columns:1.2fr .8fr}}
    .panel{border:1px solid #e5e7eb;border-radius:16px;padding:20px}
    .panel h3{margin:0 0 10px;font-size:14px;color:#334155;text-transform:uppercase;letter-spacing:.08em}
    .links{display:flex;flex-wrap:wrap;gap:12px}
    .btn{display:inline-flex;align-items:center;gap:10px;border-radius:12px;padding:12px 18px;font-weight:700;text-decoration:none;border:2px solid transparent;transition:.2s ease}
    .btn-primary{background:linear-gradient(90deg,#7c5c2d,#6f532a);color:#fff}
    .btn-primary:hover{filter:brightness(1.05)}
    .btn-secondary{background:#f8fafc;color:#0b1220;border-color:#e5e7eb}
    .btn-secondary:hover{background:#eef2f7}
    .meta{display:flex;gap:16px;flex-wrap:wrap;color:#64748b;font-size:13px}
    .meta .chip{display:inline-flex;gap:8px;align-items:center;background:#f1f5f9;border:1px solid #e2e8f0;border-radius:999px;padding:6px 10px}
    .footer{padding:16px 24px;border-top:1px solid #eef2f7;color:#94a3b8;font-size:12px;text-align:center}
    .mono{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,monospace}
  </style>
</head>
<body>
  <div class="wrap">
    <main class="card" role="main" aria-labelledby="title-500">
      <section class="top">
        <span class="badge" aria-hidden="true">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1a11 11 0 1011 11A11.013 11.013 0 0012 1zm0 20a9 9 0 119-9 9.01 9.01 0 01-9 9z"/><path d="M11 6h2v7h-2zM11 15h2v2h-2z"/></svg>
          Erreur 500
        </span>
        <h1 id="title-500" class="title">Un problème est survenu</h1>
        <p class="desc">Désolé, une erreur inattendue s’est produite. Réessayez dans un instant ou contactez-nous.</p>
      </section>

      <section class="content">
        <div class="panel">
          <h3>Actions rapides</h3>
          <div class="links" role="navigation" aria-label="Liens utiles">
            <a href="{{ route('home') }}" class="btn btn-primary">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3l9 7-1.5 2L18 10.5V20a1 1 0 01-1 1h-4v-6H11v6H7a1 1 0 01-1-1v-9.5L4.5 12 3 10l9-7z"/></svg>
              Retour à l’accueil
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
              Revenir à la page précédente
            </a>
          </div>
        </div>

        <div class="panel" aria-label="Assistance">
          <h3>Besoin d’aide ?</h3>
          <div class="meta">
            @php
              $wh = \App\Models\Setting::get('contact.whatsapp');
              $ms = \App\Models\Setting::get('contact.messenger');
              $digits = $wh ? preg_replace('/\D+/', '', (string)$wh) : null;
            @endphp
            @if($digits)
              <span class="chip">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20.52 3.48A11.78 11.78 0 0012.06 0C5.44 0 .06 5.28.06 11.8c0 2.08.54 4.14 1.58 5.94L0 24l6.3-1.66a11.92 11.92 0 005.76 1.46h.01c6.62 0 12-5.28 12-11.8a11.6 11.6 0 00-3.55-8.52z"/></svg>
                WhatsApp: <a class="mono" href="https://wa.me/{{ $digits }}">+216 {{ $digits }}</a>
              </span>
            @endif
            @if($ms)
              <span class="chip">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 4.98 0 11.11c0 3.5 1.74 6.62 4.47 8.65V24l4.09-2.24c1.09.3 2.25.46 3.44.46 6.63 0 12-4.98 12-11.11C24 4.98 18.63 0 12 0z"/></svg>
                Messenger: <a class="mono" href="{{ $ms }}">ouvrir</a>
              </span>
            @endif
            <span class="chip">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M2 5a2 2 0 012-2h5l2 2h9a2 2 0 012 2v3H2V5zM2 12h20v7a2 2 0 01-2 2H4a2 2 0 01-2-2v-7z"/></svg>
              Email: <span class="mono">{{ \App\Models\Setting::get('contact.admin_email', 'contact@maison216.tn') }}</span>
            </span>
          </div>
        </div>
      </section>

      <div class="footer">© {{ date('Y') }} {{ \App\Models\Setting::get('site.name', 'Maison 216') }} — Tous droits réservés.</div>
    </main>
  </div>
</body>
</html>

# Maison216 Operations, Access, and Deployment Runbook

Last updated: 2026-05-12

This document is the operational handoff for AI agents working on Maison216.

Purpose:
- centralize repo, VPS, SSH, Plesk, deployment, logs, production checks, and safety rules
- keep `docs/maison216-masterplan-migration.md` focused on product, UX, SEO, and architecture strategy
- make deployment reproducible from GitHub and safe to operate through SSH

## 1. Operating Rule for Agents

When an agent works on Maison216, the expected workflow is:

1. Understand the requested change from the product context.
2. Inspect the local codebase first.
3. Make changes locally.
4. Validate locally.
5. Commit and push only relevant files to `main`.
6. Deploy through Plesk Git over SSH.
7. Run post-deploy commands in production.
8. Verify the changed production URLs and inspect logs if anything fails.

Do not leave server-only code changes behind. Production must be reproducible from GitHub.

## 2. Local Repository

Local repo path:
- `c:\Users\WALID DEV\apps walid\site meuble tunisie\maison-216`

GitHub repo:
- `https://github.com/walkhatib39-ctrl/maison-216`

Working branch:
- `main`

Local shell:
- PowerShell on Windows

Important local rules:
- run `git status --short` before staging
- commit and push meaningful changes after each significant request
- do not commit unrelated local files
- do not stage temporary root images or unrelated deleted files unless the owner explicitly asks
- use `apply_patch` for manual edits

## 3. Production Hosting

Production app:
- `https://maison216.tn`

VPS SSH host:
- `37.59.114.202`

VPS public hostname:
- `vps-d3fd81b9.vps.ovh.net`

SSH user:
- `debian`

SSH port:
- `22`

Expected VPS hostname:
- `vps-d3fd81b9`

Plesk domain:
- `maison216.tn`

Production project path:
- `/var/www/vhosts/maison216.tn/httpdocs`

Plesk Git repository name:
- `laravel_f9de6c`

Plesk Git repository storage path:
- `/var/www/vhosts/maison216.tn/git/laravel_f9de6c`

Server PHP binary:
- `/opt/plesk/php/8.4/bin/php`

Verified server facts on 2026-05-12:
- SSH access works with the local key below
- `sudo -n` works for the `debian` user
- production project directory exists
- `artisan` exists in the production project path
- `package.json` exists in the production project path
- PHP CLI is `8.4.20`
- Node is `v20.20.2`
- npm is `10.8.2`
- `httpdocs` is not a Git worktree
- Plesk Git tracks `main` from GitHub

Important consequence:
- do not run `git pull` inside `httpdocs`; it is not a Git repository
- GitHub remains the source of truth
- use Plesk Git CLI to fetch and deploy after pushing to GitHub

## 4. SSH Access

Local SSH private key path:
- `C:\Users\WALID DEV\.ssh\maison216_codex`

Never paste the private key into chat or commit it.

Basic SSH test from PowerShell:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" -o BatchMode=yes debian@37.59.114.202 'whoami; hostname; pwd'
```

Expected output includes:

```text
debian
vps-d3fd81b9
/home/debian
```

Sudo check:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" -o BatchMode=yes debian@37.59.114.202 'sudo -n true && echo SUDO_OK || echo SUDO_NEEDS_PASSWORD'
```

Project shell check:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "cd /var/www/vhosts/maison216.tn/httpdocs && pwd && test -f artisan && echo ARTISAN_OK"'
```

PowerShell quoting warning:
- use single quotes around remote shell commands when the command contains `$`, `$(...)`, pipes, or shell variables
- otherwise PowerShell may expand them locally before SSH sends the command

Preferred remote PHP variable pattern:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "cd /var/www/vhosts/maison216.tn/httpdocs && PHP_BIN=/opt/plesk/php/8.4/bin/php; $PHP_BIN -v | head -n 1"'
```

## 5. Production Logs

Laravel log:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "cd /var/www/vhosts/maison216.tn/httpdocs && tail -n 160 storage/logs/laravel.log"'
```

Plesk / web server logs:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "tail -n 120 /var/www/vhosts/system/maison216.tn/logs/error_log 2>/dev/null; tail -n 120 /var/www/vhosts/system/maison216.tn/logs/proxy_error_log 2>/dev/null"'
```

Rule:
- when a production page returns `500`, inspect logs before guessing
- use the exact exception line, file, and stack frame to fix the issue

## 6. Database and Schema Verification

Prefer Laravel schema checks through `artisan tinker --execute`.

Check current database name:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "cd /var/www/vhosts/maison216.tn/httpdocs && PHP_BIN=/opt/plesk/php/8.4/bin/php; $PHP_BIN artisan tinker --execute=\"dump(DB::connection()->getDatabaseName());\""'
```

Check a table:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "cd /var/www/vhosts/maison216.tn/httpdocs && PHP_BIN=/opt/plesk/php/8.4/bin/php; $PHP_BIN artisan tinker --execute=\"dump(\\Illuminate\\Support\\Facades\\Schema::hasTable('\'products\''));\""'
```

Check columns:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "cd /var/www/vhosts/maison216.tn/httpdocs && PHP_BIN=/opt/plesk/php/8.4/bin/php; $PHP_BIN artisan tinker --execute=\"dump(\\Illuminate\\Support\\Facades\\Schema::getColumnListing('\'products\''));\""'
```

Rules:
- never invent columns
- verify production schema before schema-sensitive fixes
- never print `.env` contents into chat
- do not run destructive SQL without explicit owner approval
- do not run migrations blindly on this project

Migration rule:
- run `artisan migrate --force` only when the request includes database changes and the migration has been verified locally
- for Blade, Tailwind, content, controller, route, and SEO page work, do not run migrations

## 7. Deployment Reality

Current hosting/deployment:
- Plesk
- Plesk Git is the deployment layer
- `httpdocs` is a deployed copy, not a Git worktree

Production path:
- `/var/www/vhosts/maison216.tn/httpdocs`

Plesk Git repository:
- domain: `maison216.tn`
- name: `laravel_f9de6c`
- type: `pull`

Check Plesk Git repository:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n plesk ext git --list -domain maison216.tn'
```

Check last fetched commit:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n plesk ext git --get-last-commit -domain maison216.tn -name laravel_f9de6c'
```

Expected flow after pushing to GitHub:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n plesk ext git --fetch -domain maison216.tn -name laravel_f9de6c'
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n plesk ext git --get-last-commit -domain maison216.tn -name laravel_f9de6c'
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n plesk ext git --deploy -domain maison216.tn -name laravel_f9de6c'
```

Alternative:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n plesk ext git --async-deploy -domain maison216.tn -name laravel_f9de6c'
```

Use `--deploy` when you need deterministic command output. Use `--async-deploy` only when a non-blocking deployment is acceptable.

## 8. Standard Post-Deploy Commands

Run after Plesk has deployed the latest GitHub commit.

Default post-deploy command for UI, Blade, route, controller, SEO, and content changes:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "cd /var/www/vhosts/maison216.tn/httpdocs && npm ci && npm run build && PHP_BIN=/opt/plesk/php/8.4/bin/php; $PHP_BIN artisan optimize:clear; $PHP_BIN artisan config:cache; $PHP_BIN artisan view:cache"'
```

If only PHP/Blade changed and no Tailwind classes or frontend assets changed:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "cd /var/www/vhosts/maison216.tn/httpdocs && PHP_BIN=/opt/plesk/php/8.4/bin/php; $PHP_BIN artisan optimize:clear; $PHP_BIN artisan config:cache; $PHP_BIN artisan view:cache"'
```

If `composer.json` or `composer.lock` changed:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "cd /var/www/vhosts/maison216.tn/httpdocs && composer install --no-dev --optimize-autoloader && PHP_BIN=/opt/plesk/php/8.4/bin/php; $PHP_BIN artisan optimize:clear"'
```

Do not run `route:cache` by default:
- this project has closure routes in `routes/web.php`
- route caching may fail or create confusing deployment errors

## 9. Production Verification

Check whether `httpdocs` is a Git worktree:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "cd /var/www/vhosts/maison216.tn/httpdocs && test -d .git && git rev-parse --short HEAD || echo httpdocs-is-not-a-git-worktree"'
```

Check a deployed file exists:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'sudo -n bash -lc "test -f /var/www/vhosts/maison216.tn/httpdocs/resources/views/site-structure/sur-mesure-product.blade.php && echo TEMPLATE_DEPLOYED || echo TEMPLATE_MISSING"'
```

HTTP smoke test:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'curl -I -sS https://maison216.tn | head -n 20'
```

Check strategic pages:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" debian@37.59.114.202 'for p in /menuiserie-bois /aluminium /fer-metal /sur-mesure /sur-mesure/cuisine-sur-mesure; do code=$(curl -k -s -o /tmp/maison216_page.html -w "%{http_code}" https://maison216.tn$p); title=$(grep -o "<title>[^<]*" /tmp/maison216_page.html | head -n 1 | sed "s/<title>//"); echo "$code $p :: $title"; done'
```

Important URL convention:
- canonical URLs are generally without trailing slash
- trailing slash requests may redirect
- test canonical paths without trailing slash when checking status codes

## 10. Current Strategic Page Status

Implemented as dedicated templates:
- `/`
- `/menuiserie-bois`
- `/aluminium`
- `/aluminium/fenetre-aluminium`
- `/aluminium/porte-aluminium`
- `/aluminium/garde-corps`
- `/aluminium/moustiquaire`
- `/aluminium/volet-roulant`
- `/aluminium/brise-soleil`
- `/fer-metal`
- `/fer-metal/portail-fer-forge`
- `/fer-metal/pergola-metallique`
- `/fer-metal/garde-corps`
- `/fer-metal/escalier-metallique`
- `/sur-mesure`
- `/sur-mesure/cuisine-sur-mesure`
- `/sur-mesure/dressing-sur-mesure`
- `/sur-mesure/placard-sur-mesure`
- `/sur-mesure/meuble-tv-sur-mesure`
- `/sur-mesure/bureau-sur-mesure`
- `/projets/agencement-immobilier-neuf`
- `/projets/agencement-cafe-restaurant`
- `/projets/agencement-bureau-entreprise`
- `/projets/agencement-magasin`
- `/projets/amenagement-villa-maison`
- `/projets/amenagement-exterieur`

Known missing strategic project pages:
- `/projets`

Future strategic pages not yet fully modeled:
- `/realisations`
- `/programme-partenaire`
- `/guides`
- `/guides/guide-de-prix`
- `/guides/conseils`

## 11. Images and Public Assets

Production public image path:
- `/var/www/vhosts/maison216.tn/httpdocs/public`

Large product image library:
- `/var/www/vhosts/maison216.tn/httpdocs/public/images`

Key crafted site assets are under:
- `public/assets/home/`
- `public/assets/home/realizations/`

Rules:
- do not delete `public/images`; it contains the large product catalogue image library
- when adding homepage or landing assets, put them under `public/assets/...`
- after changing image references or Tailwind classes, run `npm run build`

## 12. Plesk and Domain Notes

Plesk panel:
- `https://37.59.114.202:8443`
- domain shown in Plesk: `maison216.tn`

Plesk document root shown:
- `httpdocs/public`

Production project root still contains the Laravel app:
- `/var/www/vhosts/maison216.tn/httpdocs`

Do not move the Laravel app manually. Plesk serves `public` as the web root.

## 13. Production Safety Rules

Do:
- inspect logs before fixing production `500`s
- verify production schema before schema-sensitive code
- push durable code changes to GitHub before deployment
- deploy through Plesk Git, not manual file edits
- run `npm run build` when Tailwind classes, JS, CSS, or frontend assets changed
- clear and rebuild caches after deployment
- test the changed production URLs

Do not:
- paste secrets, private SSH keys, DB passwords, or `.env` contents into chat
- run destructive commands such as `rm -rf`, `git reset --hard`, direct DB deletes, or mass file moves without explicit approval
- edit production files as the only copy of a fix
- run migrations unless database changes are explicitly part of the task
- run `route:cache` by default
- assume `httpdocs` is a Git worktree

## 14. How to Remove SSH Access Later

When the temporary agent SSH access is no longer needed, remove the public key from:

```bash
/home/debian/.ssh/authorized_keys
```

Then test that the key no longer works:

```powershell
ssh -i "$env:USERPROFILE\.ssh\maison216_codex" -o BatchMode=yes debian@37.59.114.202 'whoami'
```

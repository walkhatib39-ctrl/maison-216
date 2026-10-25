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


## 25/10/2026 — Fichiers et inspirations dans Leads Central

Production vérifiée : export enrichi `public/lead-export.php` et helper
`app/Support/MaisonLeadExport.php`. Le jeton existant est conservé hors Git dans
`storage/app/private/leadscentral-export-token` (0600, propriétaire du site), sans rotation.
Ne pas remplacer ce fichier privé lors du déploiement. Export authentifié en Bearer,
manifestes sans chemins privés ni IP/user-agent. Documents autorisés par demande et index ;
realpath confiné à lead-attachments dans stockage privé ou ancien stockage local.
HEIC converti en JPEG pour aperçu, original conservé. Cache privé no-store.

Le CRM live est `/home/leadsc/apps/leadscentral` sur 51.75.146.135 (utilisateur leadsc).
Correctif reproductible : `deploy/leadscentral-maison216.patch` (appliquer au CRM, pas au site).
Fiche large : inspiration/photo/options/lien, dimensions/délai, message et liens cliquables,
apercus images/PDF privés, téléchargement original, brouillon sans redemander les dimensions
présentes. La synchronisation Maison216 relit la source et met à jour uniquement les champs
source si source_revision change, jamais followup ni date/identité du CRM.

Reprise exécutée : 44 fiches enrichies sur 45 présentes, 8 fichiers accessibles dans 6 fiches.
Source = 47 demandes/9 fichiers ; suppressions CRM volontaires 48,50,51 conservées (51 porte
le neuvième fichier). Ancienne fiche CRM source 30 absente de Maison216 : gardée sans modification.
Comparaison avant/après : followup et dates inchangés. Seconde passe = 0 modifications.
Tests : 8 aperçus HTTP 200 dont 3 HEIC convertis et PDF historique 175771 octets,
accès anonyme source/CRM 401, document non rattaché 404. PDF et inspiration rendus dans le navigateur.
PHP lint, TypeScript serveur/client et builds réussis. Aucun devis ni message envoyé.
Sauvegardes : `/root/maison216-backups/leads-export-before-20261025.tar.gz` côté source ;
`/home/leadsc/backups/maison216-before-20261025.tar.gz` et
`maison216-leads-before-20261025.json` (0600) côté CRM.
Déploiement limité aux fichiers concernés : ne pas rejouer tout le checkout local ancien
sur la production. Les autres changements locaux préexistants n'ont pas été inclus.


## 25/10/2026 — Opportunités réseau et transmission WhatsApp manuelle

Demande de Walid : détecter les besoins pertinents de TuniBusiness et Medina Construction,
les présenter sur la fiche Maison216, validation obligatoire avant proposition. Clarification
explicite : aucun compte équipe à créer ; Walid transmet lui-même par WhatsApp.
Parcours en ligne : À valider / À transmettre / Transmises / Écartées. 11 suggestions sur
90 jours lors du contrôle (détection à partir du besoin écrit, aucun OCR/analyse de pièces jointe
prétendu). Le lot et les éléments justificatifs sont modifiables. Texte à transmettre révisable
avant validation ; original conservé. Documents du client cochés individuellement, devis des
fournisseurs TuniBusiness exclus. Copier pour WhatsApp produit seulement le texte validé et la
liste des pièces à joindre ; les fichiers sont à télécharger et à ajouter manuellement par Walid.
Le bouton Marquer transmis par WhatsApp est une confirmation humaine, pas une preuve technique
de livraison et n'est jamais déclenché par la copie ou le téléchargement. Aucun envoi automatique.

Deux nouvelles tables de liaison/journal, sans copie ni modification des leads sources :
network_opportunities (clé unique destination_id + source_lead_id) et network_opportunity_events.
Source, documents, contact et besoin hachés ; un changement impose une nouvelle validation.
Suppression d'une source retire la liaison ; historique des actions séparé. Regroupement visuel
conservateur des messages similaires même contact, y compris intersites, et exclusion d'un même
besoin déjà présent côté Maison216. Ce n'est pas une fusion/suppression de données.
Statuts/notes source non partagés ; seul un indicateur déjà contacté aide à coordonner.
Les données d'identification du client et le besoin sont revus par l'administrateur.

Droits : rôle et périmètre relus en base ; validation/révocation/transmission réservées à l'admin.
L'accès cible pour un éventuel compte Maison216 n'expose que les propositions approuvées et les
fichiers cochés, jamais les sites source complets. Aucun compte ni droit nouveau créé ici.
Route dédiée documents : source TuniBusiness via Bearer privé ; pièces Medina reçues par mail
lues localement avec realpath sous uploads/mail, sans URL publique renvoyée. Aperçu PDF/image,
autres formats téléchargeables, limite 25 Mo, no-store/nosniff. Les fichiers ne sont pas publiés.

Validation : compilation TypeScript serveur/client et Vite, schéma Prisma validé ; tests Fastify
sur base simulée couvrent validation admin, révocation, changement source, données internes
exclues, fichiers sélectionnés, unicité, attribution et confirmation WhatsApp idempotente. Tests
production en lecture seule : liste 11 fiches, toutes en attente, accès anonyme 401 ; JPEG
TuniBusiness 1524927 octets et PDF Medina 767720 octets ouverts via la route privée. Aucun vrai
lead approuvé, transmis ou contacté pendant les tests.

Reproduction : appliquer deploy/leadscentral-maison216-network.patch au CRM live ; tables dans
deploy/leadscentral-maison216-network.sql ; tests deploy/test-maison216-network.cjs à exécuter
à la racine server avec compilation dist-network-20261025. Ne pas rejouer le checkout local
CRM ancien. Sauvegardes /home/leadsc/backups/maison-network-before-20261025.tar.gz et
maison-network-schema-before-20261025.prisma. Les tables étaient vides à la livraison, aucune
validation à annuler. Les accès privés existants et les autres sites sont conservés.


## 25/10/2026 — Dossier PDF / ZIP et navigation réseau dans les filtres

Demandes successives de Walid : télécharger une fiche complète pour WhatsApp puis intégrer
Opportunités du réseau dans la barre Tous / Non vus / À contacter. Mis en ligne : bouton réseau
avec compteur, vue remplaçant la liste directe, plus de bloc réseau au-dessus des graphiques.
Les filtres directs sont conservés au retour et la vue est réinitialisée lors d'un changement de
site. Le composant réseau reste monté masqué pour son compteur ; il n'y a pas deux listes visibles.

Dans une opportunité validée : Télécharger la fiche PDF ou PDF + originaux (ZIP).
Synthèse Maison216 : besoin validé, coordonnées, lot, références sources et inventaire des pièces.
Photos mises à l'échelle sur pages annexes ; PDF sources fusionnés sans modifier leurs pages.
ZIP = synthèse et annexes lisibles + tous les originaux sélectionnés (dont DWG/tableurs ou PDF
protégés/illisibles). Le mode PDF refuse les pièces non intégrables en indiquant le ZIP, et tout
échec de récupération bloque le dossier incomplet. Aucun envoi ni statut transmis automatique.

Contrôle serveur POST network-opportunities/export : uniquement validations actuelles et fichiers
cochés. Contrôle à nouveau après préparation pour prévenir un export après révocation/changement.
Création locale dans le navigateur, aucun service tiers ni stockage public. Chargement différé de
pdf-lib 1.17.1, JSZip 3.10.1, polices libres DejaVu 2.37.3 ; licence publiée sous /licenses/.
Limites : 50 pièces, 100 Mo téléchargés, 200 pages d'annexes. Images réduites à 2400 px pour le PDF,
originaux conservés dans le ZIP ; doublons binaires évités. Accents et arabe vérifiés au rendu.

Tests : routes sur base simulée (validation, fichiers autorisés, état périmé, notes internes
exclues), génération d'une synthèse longue de 6 pages avec photo et PDF de 2 pages, refus d'une
fiche non validée et d'annexes incompatibles en mode PDF. Rendu Poppler inspecté. En production :
export anonyme 401, non validé 409, navigation réseau/Tous contrôlée visuellement. Aucune vraie
opportunité validée pour les tests. Builds Vite et TypeScript serveur réussis. Vérification réelle
client avec tsconfig.app.json : pas d'erreur sur NetworkOpportunities, QuoteRequests, networkPdf
et leadGroups ; erreurs préexistantes ailleurs (dont MyNumbers, MaisonDossier, imports inutilisés)
non traitées dans ce périmètre. Le simple tsc --noEmit du tsconfig racine vide n'est pas probant.

Reproduction : deploy/leadscentral-maison216-pdf-ux.patch, tests deploy/test-pdf-core.cjs (client,
fixture deploy/fixtures/network-pdf-photo.jpg à copier en test-network-photo.jpg), et
 deploy/test-network-pdf.cjs (server, dist-network-pdf-20261025). Sauvegarde serveur
/home/leadsc/backups/network-pdf-before-20261025.tar.gz ; sauvegardes QuoteRequests/SiteDetail
supplémentaires network-pdf-*.before.tsx. Captures et PDF synthétique dans D:/Maison216-network-pdf.


## Extension réseau Litorra — session du 25/10/2026

Litorra ID b1043142-f5fa-480c-a76e-ba0cf97b341f : sources autorisées TuniBusiness,
Medina Construction et Maison216. Le même moteur est désormais paramétré par destination,
sans duplication de leads ni modification du suivi source. Clé unique destination + source
et validation distincte pour chaque marque ; une validation Maison216 ne vaut pas pour Litorra.
Aucun compte créé, aucune proposition approuvée ni transmise automatiquement.

Qualification Litorra : peinture intérieure/extérieure, façades, enduits décoratifs, béton ciré,
stucco, peintures techniques à vérifier. Filtres projets de peinture / lot dans chantier global /
produits à fournir. Fourniture retenue seulement sur intention explicite liée aux produits ;
partenariats commerciaux, peinture automobile, négations et simple finition d'un meuble écartés.
Justification par extraits du texte ; brief proposé limité au volet peinture, révisable par Walid.
Budget de chantier global non assimilé au budget peinture. Demandes de plus de 30 jours signalées.
Les fichiers ne sont pas analysés automatiquement. Ce sont des suggestions, jamais une décision
commerciale autonome. Période initiale 90 jours, historique jusqu'à 730 jours.

Documentation vérifiée : 19 fiches / 21 demandes à valider sur 90 jours lors du contrôle,
4 de TuniBusiness et 17 de Medina ; aucune demande Maison216 correspondante à cette date mais
la source est bien incluse. Accès privé aux documents Maison216, y compris JPEG d'aperçu HEIC,
original conservé dans le ZIP. PDF et message WhatsApp marqués Litorra ; exports de destinations
mélangées refusés côté navigateur. Maison216 conserve sa liste et ses règles (11 fiches).

Tests : isolation de destination, validation indépendante, accès aux sources configurées,
documents Maison216 / HEIC, export limité au texte validé, positifs/négatifs de qualification,
régression Maison216. Tests API en lecture seule : anonyme 401, non validé 409, HEIC Maison216
converti 200 image/jpeg 122317 octets via Litorra. PDF synthétique 6 pages rendu et contrôlé sous
la marque Litorra. TypeScript serveur et Vite réussis ; aucun diagnostic sur les composants
réseau et PDF dans la vérification tsconfig.app.json (autres erreurs préexistantes non modifiées).

Patch reproductible deploy/leadscentral-litorra-network.patch et test
 deploy/test-litorra-network.cjs (server, dist-litorra-network-20261025).
Sauvegarde /home/leadsc/backups/litorra-network-before-20261025.tar.gz. Aucun changement de schéma
ni migration des décisions existantes nécessaires. Preuves locales D:/Litorra-network.


## 26/10/2026 — Inspirations générées dans les fiches sans visuel

Demande de Walid : voir une proposition visuelle dès l'ouverture d'une demande sans photo,
la transmettre au client pour accélérer l'accord esthétique avant devis/acompte/production.
Implémentation : rubrique Inspiration proposée dans MaisonDossier, fiches directes Litorra et
opportunités réseau ouvertes par l'admin. Génération initiale à l'ouverture si le texte est
suffisamment détaillé, sans photo ni inspiration déjà choisie. Fiches tests/administratives exclues.
Textes courts : précision manuelle nécessaire. L'image est privée et mise en cache par demande,
destination, empreinte source et brief/ajustements. Pas de relance automatique à chaque ouverture.
Versions conservées, variante sur précisions explicites, anciennes versions signalées si le
besoin évolue. 2 tâches simultanées et 20 nouvelles inspirations par propriétaire/24h ; reprises
manuelles après erreur. Tâches interrompues marquées en échec après 10 min, sans boucle de relance.

API Image OpenAI gpt-image-2.5-flare (accès vérifié avec la clé existante), medium 1536x1024.
Aucune clé créée, révélée ou copiée dans les dépôts ; crédit OpenAI du propriétaire utilisé.
Prompt limité au besoin, noms/coordonnées du contact nettoyés, pas de fichier client envoyé.
Instructions de photographie conceptuelle, pas de plan technique, cotes inventées ou preuves
commerciales ; contraintes visuelles exactes seulement lorsqu'elles sont fournies. La demande
de devis/plan cotée est retirée du prompt visuel pour éviter des schémas de fabrication inventés.
Marquage déterministe ajouté avec sharp : INSPIRATION GÉNÉRÉE - À VALIDER, dimensions/fabrication
à confirmer. L'image reste une proposition, à contrôler humainement. Aucun plan PDF n'est analysé.

Boutons télécharger l'image / copier le message au client, sans envoi automatique. Suivi distinct
par version : proposé, envoyé, modifications demandées, accord client reçu. Ce dernier exige une
note de confirmation saisie par l'admin ; ne valide ni fabrication, ni devis, ni acompte. Aucun vrai
client marqué d'accord durant les tests. Aucune modification des suivis commerciaux existants.

Table lead_inspirations (SQL et modèle Prisma), clé unique de cache et FK vers lead. Fichiers
sous server/private/inspirations (0700, PNG 0600), jamais sous uploads public. Endpoints admin
avec propriétaire/site/demande vérifiés ; image d'une autre fiche 404, accès anonyme 401.
Cache prêt consultable même si la clé doit être reconfigurée ; les erreurs fournisseur sont des
codes génériques, sans divulgation de secrets. La légende de provenance est intégrée à l'image.

Vérifié en production : visuel Abdallah créé avec imagegen puis associé en état proposed ;
génération API réelle réussie sur la demande de meuble TV Riahi. Une variante photographique
sans cotes a ensuite été générée après contrôle de l'image ; première version conservée.
Réouverture/POST identique = cache, sans nouvel appel facturé. Tous les états client restent
proposed. Tests simulés : autorisations, photo existante, fiche courte/test, cache, source périmée,
confirmation explicite et apposition du marquage. TypeScript serveur/Vite passés ; aucun nouveau
diagnostic sur LeadInspiration, NetworkOpportunities et QuoteRequests dans tsconfig.app.json.

Sources : https://developers.openai.com/api/reference/resources/images/methods/generate
et https://sharp.pixelplumbing.com/api-constructor/ (texte Pango avec police locale DejaVu).
Patch deploy/leadscentral-inspirations.patch, migration deploy/leadscentral-inspirations.sql,
test deploy/test-lead-inspirations.cjs (server, dist-inspirations-20261026 ; fixture photo client
synthétique des tests PDF précédents). Dépendance sharp 0.34.5. Sauvegarde complète avant intervention
/home/leadsc/backups/lead-inspirations-before-20261026.tar.gz. Preuves D:/Lead-inspirations ; copies
locales des exemples dans output/lead-inspirations, hors commit. Ne pas effacer les images privées
lors des déploiements ; ne pas rejouer une génération existante pendant une reprise.

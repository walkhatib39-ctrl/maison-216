# Maison 216 — Dossier projet (Mise à jour)

## 1) Contexte & périmètre
- Secteur: E-commerce meubles & décoration en Tunisie
- Paiement: À la livraison (Cash on Delivery), pas de paiement en ligne
- Commande: Checkout invité (guest) + bouton “Commander via WhatsApp” et “Messenger”
- Livraison: Tunisie entière (24 gouvernorats), frais fixes 20 DT, délai affiché 3–7 jours
- Langue: Français uniquement
- Devise: TND (affichage “259 DT”, “3050 DT” sans séparateur mille et sans décimales)
- Catégories: fournies par le client (aucune gestion depuis l’admin dans cette V1)
- Branding: Nom du site “Maison 216”; logo/favicon modifiables via Settings (admin)
- Objectif: Site hyper moderne, professionnel, mobile-first, UX claire et orientée conversion

## 2) Stack & versions
- Backend: Laravel 12.31.1 (PHP 8.2.26, Composer 2.8.8)
- Frontend: Tailwind CSS + Flowbite (+ Flowbite Typography), Alpine.js, Vite
- Auth: Laravel Breeze (Blade)
- Base de données: MySQL (WAMP), driver `mysql`
- Runtime local: Node 22.14.0, npm 10.9.2
- Envoi email: MAIL_MAILER=log (à configurer en prod)
- Timezone/Locale: Africa/Tunis, fr_FR

## 3) Architecture & modules

### 3.1 Front Office (V1)
- Accueil (/): 
  - Section catégories principales (avec sous-catégories)
  - “Nouveautés” (12 derniers produits actifs)
- Catégories (/c/{slug}): 
  - Liste produits avec filtres basiques: mot-clé (LIKE sur titre), prix min/max (DT), marque
  - Navigation sous-catégories et “Voir aussi” (fratrie)
- Produit (/p/{slug}):
  - Galerie images, description courte/longue (HTML), tableau caractéristiques (attributs JSON)
  - Formulaire “Commande rapide” (guest) enregistrant la commande (COD)
  - Boutons WhatsApp/Messenger (liens construits depuis Settings)
- Nav: menu desktop avec dropdown des sous-catégories; mobile menu (collapsible)
- Performances/UX: mobile-first, Tailwind/Flowbite, transitions douces

### 3.2 Admin (V1.1 livré)
- Layout: sidebar admin dédiée (Blade) avec modules Accueil, Produits, Commandes, Paramètres, SEO
- Redirection post-login: les admins sont redirigés automatiquement vers `/admin`
- Dashboard: KPIs (commandes/jour, total commandes, CA estimé, nb produits, nb catégories)
- Produits:
  - CRUD complet (titre, slug auto, prix DT→millimes, stock, image principale, galerie multiple, catégorie, actif)
  - Upload images multiples via Storage public (avec `storage:link`)
  - Import JSON via UI (formulaire) reprenant la logique de la commande CLI
  - Filtres: recherche, catégorie, actif/inactif, marque
- Catégories:
  - Arborescence hiérarchique (Parent > Enfant > Petit-enfant)
  - Compteurs de produits récursifs (incluant sous-catégories)
  - CRUD complet via Modales (Alpine.js)
  - Suppression intelligente: Cascade Delete (supprime produits et enfants) avec avertissement
  - Bulk Actions: Sélection multiple et suppression en masse
- Commandes:
  - Listing avec filtres (q, status, ville, date du/au)
  - Vue détail: items, récap (subtotal, shipping, total), note client
  - Changement de statut (Nouveau → Confirmé → En préparation → En livraison → Livré/Annulé)
  - Impression “bon de préparation”
  - Export CSV (UTF-8 + BOM compatible Excel)
- Paramètres (Settings):
  - WhatsApp, Messenger, frais de livraison (DT→millimes), logo, favicon
  - Toggles checkout WhatsApp/Messenger
- SEO:
  - Page placeholder (prochaines itérations: meta dynamiques, sitemap.xml, robots.txt)

### 3.3 Core / Import
- Catégories: 
  - Seeding depuis `database/seeders/data/categories.md`
  - Logique métier: `getTotalProductsCountAttribute()` (récursif) et `booted()` (deleting event pour cascade)
- Import produits: commande artisan qui lit des JSON client (images, description HTML, prix “259,00 DT”, attributs “productInfo” → normalisés vers JSON)
- Prix: stockés en millimes (int) pour éviter flottants; helpers d’affichage en “DT”

## 4) Schéma de données (high level)
- categories: id, parent_id (nullable, FK self), name, slug unique, icon (nullable), position, timestamps
- products: id, category_id (nullable FK), title, slug unique, price_millimes, compare_at_millimes (nullable), stock, sku (nullable), brand (nullable), main_image (nullable), short_description (text nullable, HTML), long_description (longText nullable, HTML), attributes (json nullable), is_active (bool), timestamps
- product_images: id, product_id FK, url, alt (nullable), position, timestamps
- orders: id, full_name, phone, phone_alt (nullable), email (nullable), city, address, postal_code (nullable), payment_method (“COD”), status (strings FR), shipping_fee_millimes (20 DT par défaut), subtotal_millimes, total_millimes, customer_note (nullable), admin_note (nullable), placed_at (timestamp), timestamps
- order_items: id, order_id FK, product_id (nullable FK), snapshot: product_title, product_sku, product_main_image, unit_price_millimes, quantity, line_total_millimes, attributes (json nullable), timestamps
- settings: id, key unique, value (json), group (index), timestamps
- users: is_admin (bool, index) ajouté à la table

## 5) Import JSON produits
- Emplacement exemple: `database/seeders/data/products/meuble-tv.json`
- Formats acceptés:
  - Tableau de produits JSON (comme l’exemple)
  - Ou `{ "products": [ ... ] }`
- Champs supportés par l’import:
  - title (obligatoire)
  - price (string: “259,00 DT”, “229 DT”, etc.) → converti en millimes
  - shortDescriptionHtml / description (HTML court)
  - longDescriptionHtml (HTML long)
  - mainImage (URL)
  - galleryImages (array URLs)
  - productInfo (objet clé/valeur) → mappe vers `attributes` (JSON), avec normalisation espaces
  - url (source_url ajouté dans attributes)
- Assignation de catégorie:
  - Option CLI `--category=slug` (ex: `meubles-tv-supports-tv`)
  - Option `--brand=...`, `--active=1|0`, `--limit=N`, `--dry-run`
- Commandes:
  - `php artisan app:import-products "database/seeders/data/products/meuble-tv.json" --category=meubles-tv-supports-tv --active=1`
  - Dry run: `php artisan app:import-products path --dry-run --limit=10`

## 6) Routes & contrôleurs
- Front:
  - `/` → `HomeController@index`
  - `/c/{slug}` → `CategoryController@show` (filtres q, min, max, brand)
  - `/p/{slug}` → `ProductController@show`
  - POST `/order/quick` → `ProductController@quickOrder`
- Auth (Breeze):
  - `/login`, `/register`, etc. Les admins sont redirigés automatiquement vers `/admin` après login.
- Admin (V1.1 livré):
  - Group `/admin` (middlewares: auth + admin), sidebar dédiée
  - `Admin\DashboardController@index` (KPIs)
  - Produits:
    - `Admin\ProductController` (resource: index/create/store/edit/update/destroy)
    - Import JSON UI: `GET /admin/products/import`, `POST /admin/products/import`
  - Catégories:
    - `Admin\CategoryController` (resource)
    - Bulk Delete: `DELETE /admin/categories/bulk-destroy`
  - Commandes:
    - `Admin\OrderController` (resource: index/show/update/destroy)
    - Export CSV: `GET /admin/orders/export`
    - Impression: `GET /admin/orders/{order}/print`
  - Paramètres:
    - `Admin\SettingController@index` + `POST /admin/settings`
  - SEO:
    - `Admin\SeoController@index` (placeholder)

## 7) Paramètres (Settings) disponibles
- site.name: “Maison 216”
- site.tagline: “Meubles & Décoration en Tunisie”
- contact.whatsapp: “+216 …” (affiche bouton WhatsApp + liens)
- contact.messenger: “https://m.me/…” (affiche bouton Messenger)
- shipping.fee_millimes: 20000 (20 DT)
- checkout.whatsapp_enabled (bool), checkout.messenger_enabled (bool)
- ui.logo (URL/chemin), ui.favicon (URL/chemin)
- seo.currency: “TND”; seo.locale: “fr_TN” (exploitable dans étapes SEO)

## 8) Mise en place locale (WAMP)
1. Pré-requis:
   - PHP 8.2+, Composer, Node/npm, WAMP MySQL lancé
2. Installation (déjà réalisée):
   - `composer create-project laravel/laravel maison-216`
   - `.env` : `DB_CONNECTION=mysql`, `DB_DATABASE=maison_216`, `DB_USERNAME=root`, `DB_PASSWORD=`
   - Locale: `APP_LOCALE=fr`, `APP_FALLBACK_LOCALE=fr`, `APP_FAKER_LOCALE=fr_FR`, `APP_TIMEZONE=Africa/Tunis`
3. Dépendances:
   - `composer require laravel/breeze --dev && php artisan breeze:install blade`
   - `npm install && npm install flowbite flowbite-typography`
4. Tailwind/Flowbite:
   - `tailwind.config.js` inclut `./node_modules/flowbite/**/*.js` et plugins `flowbite`, `flowbite-typography`
   - `resources/js/app.js` importe `'flowbite'`
5. Migrations & seed:
   - `php artisan migrate`
   - `php artisan storage:link`
   - `php artisan db:seed` (Settings + Catégories + Admin(s) + Commandes factices)
6. Import démo Produits:
   - `php artisan app:import-products "database/seeders/data/products/meuble-tv.json" --category=meubles-tv-supports-tv --active=1`
7. Run:
   - Terminal 1: `npm run dev` (Vite)
   - Terminal 2: `php artisan serve` (http://127.0.0.1:8000)
8. Accès Admin:
   - Login admin ⇒ redirection auto vers `/admin`
   - Admins seed:
     - `admin@maison216.tn / password`
     - `walkhatib39@gmail.com / Aa09600710` (demandé par client)

## 9) Sécurité & qualité
- `short_description` et `long_description` sont rendus en HTML côté front (trusted source). À prévoir: sanitation/whitelist si source non contrôlée.
- Formulaire commande: validation Laravel, anti CSRF, limites qté (1–20), TODO captchas/ratelimiting si nécessaire.
- Concurrence stock: décrément basique, à renforcer par locks s’il y a des pics de commandes (TODO).
- SEO: meta titles/descriptions dynamiques, `sitemap.xml`, `robots.txt` (TODO).
- RGPD: pages légales placeholders à fournir et personnaliser (CGV, confidentialité, livraison/retours).

## 10) Checklist fonctionnalités

### Backend & infra
- [x] Initialisation Laravel 12 / .env (FR, fr_FR, Africa/Tunis, MySQL)
- [x] Tailwind CSS + Flowbite (+ Typography) + Vite
- [x] Breeze (auth) + `users.is_admin`
- [x] Migrations: catégories, produits, images, commandes, items, settings
- [x] Seeders: Settings, Catégories, Admins, Commandes factices (OrderSeeder)
- [x] Import JSON produits (commande artisan + UI admin)
- [x] Données démo importées (5 produits “Meuble TV”)
- [x] Middleware `admin` + alias (bootstrap/app.php)
- [x] Redirection post-login admin → `/admin`
- [x] Storage public pour uploads (logo/favicon/images produits)
- [ ] Emailing (confirmation client, notification admin)
- [ ] SEO de base (meta dynamiques, sitemap.xml, robots.txt)
- [ ] Pages légales (CGV, confidentialité, livraison/retours) placeholders

### Front Office
- [x] Accueil — catégories + nouveautés
- [x] Listing Catégorie — filtres (q, min/max, brand), navigation sous-catégories
- [x] Fiche Produit — galerie, descriptions HTML, attributs en tableau
- [x] Commande rapide (guest) — COD, frais livraison 20 DT, délai 3–7 jours
- [x] Boutons WhatsApp/Messenger (depuis Settings)
- [ ] Mapping Ville → Gouvernorat (auto) pour BR/analytique

### Admin (V1.1)
- [x] Dashboard KPIs (commandes/jour, total, CA estimé, produits, catégories)
- [x] Produits — CRUD, upload images multiples, état actif/inactif, import JSON via l’UI
- [x] Catégories — Arborescence, Compteurs récursifs, Cascade Delete, Bulk Delete
- [x] Commandes — listing/filtre, vue détail, changement de statut, impression, export CSV
- [x] Paramètres — UI pour WhatsApp, Messenger, logo, favicon, frais livraison, tagline
- [x] Gestion SEO — page placeholder
- [x] Shell Admin — Sidebar (Accueil, Produits, Commandes, Paramètres, SEO)

## 11) Roadmap & priorités (actualisée)
1) Emailing: confirmation client + notification admin; gabarits Blade fr_FR; éventuellement file log en dev.
2) SEO de base: meta dynamiques (accueil/catégorie/produit), génération sitemap.xml et robots.txt éditable.
3) Commandes: actions bulk (changement de statut), historique timeline, impression étiquette d’expédition.
4) Produits: réordonnancement drag&drop galerie, toggle actif/inactif AJAX, validation améliorée des attributs.
5) Paramètres: prévisualisation favicon/logo, validations renforcées (URL, formats).
6) Pages légales: CGV, confidentialité, livraison/retours (placeholders + contenu client).
7) Ville → Gouvernorat: table mapping pour enrichir la commande/analytique.
8) Sécurité HTML: sanitation/whitelist si les sources de descriptions ne sont pas totalement contrôlées.

## 12) Endpoints utiles (rappel)
- GET `/` (Accueil)
- GET `/c/{slug}` (Listing catégorie + filtres)
- GET `/p/{slug}` (Fiche produit)
- POST `/order/quick` (Commande rapide guest, COD)
- GET `/admin` (dashboard KPIs) — `auth` + `admin`
- Produits admin:
  - GET `/admin/products`
  - GET `/admin/products/import`, POST `/admin/products/import`
- Commandes admin:
  - GET `/admin/orders`
  - GET `/admin/orders/export` (CSV)
  - GET `/admin/orders/{order}` (détail)
  - PUT `/admin/orders/{order}` (statut/note)
  - GET `/admin/orders/{order}/print` (impression)
- Paramètres admin:
  - GET `/admin/settings`, POST `/admin/settings`
- SEO admin:
  - GET `/admin/seo` (placeholder)

## 13) Arborescence & fichiers clés
- Modèles: `app/Models/{Category,Product,ProductImage,Order,OrderItem,Setting,User}.php`
- Commande import: `app/Console/Commands/ImportProducts.php`
- Middleware admin: `app/Http/Middleware/AdminMiddleware.php` (alias dans `bootstrap/app.php`)
- Auth redirection: `app/Http/Controllers/Auth/AuthenticatedSessionController.php` (admins → `/admin`)
- Layouts:
  - Front: `resources/views/layouts/store.blade.php`
  - App/Breeze: `resources/views/layouts/app.blade.php`
  - Admin (sidebar): `resources/views/layouts/admin.blade.php` (auto via `App\View\Components\AppLayout` sur `/admin*`)
- Admin:
  - Controllers: 
    - `app/Http/Controllers/Admin/{DashboardController,ProductController,OrderController,SettingController,SeoController}.php`
  - Vues:
    - Dashboard: `resources/views/admin/dashboard.blade.php`
    - Produits: `admin/products/{index,create,edit,import}.blade.php`
    - Commandes: `admin/orders/{index,show,print}.blade.php`
    - Paramètres: `admin/settings/index.blade.php`
    - SEO: `admin/seo/index.blade.php`
- Seeders:
  - `database/seeders/{SettingSeeder,CategorySeeder,OrderSeeder,DatabaseSeeder}.php`
- Données:
  - `database/seeders/data/categories.md`
  - `database/seeders/data/products/meuble-tv.json`
- Routes: `routes/web.php`

## 14) Notes & décisions de conception
- Admin UX: sidebar persistante, pages dans `x-app-layout`; auto-layout admin sur `/admin*`.
- Redirection: forçage vers `/admin` pour les admins après login pour éviter `/dashboard`.
- Uploads: disque `public`, `storage:link` requis; URLs via `Storage::url(...)`.
- Prix: stockage en millimes (int) pour précision et simplicité d’affichage TND.
- HTML descriptions: rendues telles quelles (trusted source). À sécuriser si import source non contrôlée (sanitization).

## 15) Reste à faire (synthèse)
- Emailing (client/admin) avec gabarits fr_FR.
- SEO de base (meta dynamiques), génération `sitemap.xml`, éditeur `robots.txt`.
- Pages légales (CGV, confidentialité, livraison/retours) — placeholders + contenu.
- Mapping Ville → Gouvernorat (table de correspondance).
- Améliorations Admin: bulk actions commandes, historique, drag&drop galerie produits, toggles AJAX.
- Sanitation HTML si les imports ne proviennent pas systématiquement de source “trusted”.

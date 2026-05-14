# Maison216 - Plan refonte admin cockpit, SEO, leads et realisations

Last updated: 2026-05-14

Ce document est la reference de travail pour la refonte complete de l'espace admin Maison216.

Objectif:
- remplacer l'ancien back-office e-commerce par un cockpit de pilotage site vitrine, SEO, leads, pages et realisations
- garder le site public professionnel, stable et rapide
- permettre a l'admin de gerer les donnees utiles sans casser les pages publiques
- conserver le module e-commerce pour une future strategie catalogue, mais purger les anciennes donnees produits/categories devenues obsoletes

## 1. Decisions verrouillees

### 1.0 Regle de livraison des sprints

Avant chaque livraison de sprint, l'agent doit obligatoirement mettre a jour ce document.

La mise a jour doit inclure:
- ce qui a ete livre
- les verifications effectuees
- les remarques techniques
- les risques ou limites restants
- la prochaine action recommandee

Regle de communication:
- le message final au proprietaire doit toujours indiquer la prochaine etape prevue
- aucun sprint ne doit etre considere termine si le changelog de ce fichier n'a pas ete mis a jour

### 1.1 Pas de scripts libres dans l'admin

L'admin ne doit pas permettre de coller du JavaScript arbitraire dans le head ou le body.

Raison:
- risque XSS
- risque de casser le front
- risque d'injecter du code non maitrise en production

Ce qui est autorise:
- champs de verification Google Search Console sous forme de token uniquement
- champs de verification Bing Webmaster sous forme de token uniquement
- identifiants simples si necessaire plus tard, par exemple `G-XXXX` pour GA4, mais pas de script complet

Ce qui est interdit:
- champ `custom_head_script`
- champ `custom_body_script`
- injection HTML libre
- injection JavaScript libre

### 1.2 Canonical auto, non editable

Les URLs canonical doivent etre generees automatiquement dans le code a partir de la route publique.

L'admin ne doit pas pouvoir modifier le canonical d'une page.

Raison:
- eviter les erreurs SEO graves
- eviter les canonical croises incorrects
- garder une logique technique propre et fiable

### 1.3 Pas de page builder

L'admin ne doit pas devenir un page-builder complet.

Les pages Maison216 sont des pages strategiques avec design et copywriting controles. L'admin gere:
- SEO
- statut d'indexation
- realisations assignees
- images de realisation
- demandes entrantes
- coordonnees et identite du site

L'admin ne gere pas:
- mise en page libre
- blocs HTML libres
- texte complet de toutes les sections publiques

### 1.4 Conservation du module e-commerce, purge du catalogue obsolète

Decision mise a jour le 2026-05-14:
- le concept e-commerce est conserve
- les routes, controllers, vues, tables et menus e-commerce ne doivent plus etre supprimes
- les anciennes donnees catalogue doivent etre videes pour repartir sur une base propre

Scope de purge autorise:
- tous les produits
- toutes les categories catalogue
- toutes les images produits liees
- toutes les images categories liees
- liens pivot `collection_product`
- commandes e-commerce si le proprietaire demande explicitement une remise a zero complete

Ce qui doit etre conserve:
- tables e-commerce
- controllers e-commerce
- vues e-commerce
- routes e-commerce

Regle de securite:
- utiliser une commande Artisan avec `--dry-run` avant toute purge
- creer une sauvegarde applicative des lignes impactees avant suppression
- ne pas supprimer les images hors catalogue, notamment assets home, realisations, logo, favicon et images de pages publiques
- ne pas casser le futur redesign e-commerce qui sera defini plus tard

## 2. Diagnostic actuel

### 2.1 Admin actuel

L'admin actuel est oriente e-commerce:
- tableau de bord commandes / CA / produits
- produits
- import JSON produits
- categories
- rooms / product types / collections
- commandes
- settings limites
- page SEO placeholder

Ce modele ne correspond plus au positionnement Maison216.

### 2.2 Front actuel

Le front public est maintenant structure autour de silos:
- Menuiserie bois
- Menuiserie aluminium
- Fabrication metallique
- Sur mesure
- Projets
- Espace professionnels
- Devis
- Contact

La structure est deja centralisee dans `config/site_structure.php`.

### 2.3 SEO actuel

Les metas sont majoritairement codees dans `SitePageController`.

Probleme:
- l'admin ne peut pas voir toutes les pages
- l'admin ne peut pas savoir quelles pages ont une meta title/description incomplete
- l'admin ne peut pas gerer les images OG
- l'admin ne peut pas suivre l'etat SEO par silo

### 2.4 Leads actuels

Les formulaires envoient principalement des emails.

Probleme:
- pas de base de donnees centralisee des demandes
- pas de pipeline commercial
- pas de statut
- pas de source page fiable
- pas de suivi des demandes professionnels

### 2.5 Realisations actuelles

Les realisations sont codees en dur dans les vues.

Probleme:
- pas d'upload admin
- pas d'assignation a une page
- pas de reutilisation entre pages
- pas de tri manuel
- pas de gestion rapide par categorie/silo

## 3. Architecture admin cible

## 3.0 Doctrine UI/UX admin

Cette doctrine est obligatoire pour toute implementation de l'admin Maison216.

L'objectif n'est pas de faire un admin decoratif. L'objectif est de construire un cockpit professionnel qui permet de voir, filtrer, decider et agir rapidement.

### 3.0.1 Principes fondateurs

1. L'admin sert l'operationnel, pas le marketing.

Le site public porte le discours de marque. L'admin execute.

Interdit dans l'admin:
- phrases promotionnelles
- grands textes explicatifs inutiles
- ton coach ou paternaliste
- slogans publics reutilises comme aides produit

Attendu:
- libelles courts
- information factuelle
- action claire
- statut visible

2. Aucun nom technique interne visible.

Ne jamais exposer a l'admin des noms comme:
- `site_pages`
- `realization_site_page`
- `payload`
- `source_page_path`
- `quote`
- `professional`
- noms de constantes ou enums bruts

Afficher:
- Pages
- Realisations
- Demandes de devis
- Demandes professionnels
- Source
- Statut

3. Chaque bloc doit repondre a une question operationnelle.

Si un bloc ne permet pas de comprendre, decider ou agir, il doit etre retire.

Questions typiques:
- quelles demandes sont a traiter ?
- quelles pages ont un probleme SEO ?
- quelles pages n'ont pas encore de realisations ?
- quelle realisation est publiee ou brouillon ?
- quelle information site est affichee au public ?

4. Une action principale par zone.

Chaque page admin doit avoir une action principale evidente:
- Pages & SEO: `Synchroniser les pages` ou `Enregistrer`
- Realisations: `Ajouter une realisation`
- Demandes: `Traiter la demande`
- Parametres: `Enregistrer les parametres`

Les actions secondaires doivent rester secondaires.

### 3.0.2 Hierarchie d'une page admin

Ordre standard:

1. Titre de page dans le layout.
2. Sous-titre neutre si necessaire, une ligne maximum.
3. Indicateurs utiles, 4 maximum.
4. Barre d'action: recherche, filtres, action principale.
5. Vue principale: table, liste, grille ou formulaire.
6. Footer de vue: total, pagination, derniere mise a jour si utile.

Un utilisateur doit comprendre en moins de 3 secondes:
- ou il est
- ce qu'il voit
- quelle action est possible

### 3.0.3 Copywriting produit

Interdit:
- "Vous devriez..."
- "Pensez a..."
- "L'objectif est..."
- "Optimisez votre business..."
- "Booster votre SEO..."
- "Gardez le statut a jour..."
- paragraphes pedagogiques longs
- libelles vagues: `OK`, `Action`, `Valider`, `Voir plus`

Attendu:
- `Ajouter une realisation`
- `Enregistrer les metas`
- `Marquer comme contacte`
- `Assigner a une page`
- `Publier`
- `Mettre en brouillon`
- `Exporter`
- `Filtrer`

Regle:
- un bouton commence par un verbe
- un badge de statut est un mot court
- une aide de champ est une phrase maximum

### 3.0.4 Structure visuelle

Direction visuelle:
- admin clair, calme, B2B
- fond page legerement teinte
- surfaces secondaires sobres
- cartes/tables blanches avec border fin
- ombres faibles
- pas de gradients lourds dans les cartes KPI
- pas d'icones decoratives massives

Palette recommandee:
- fond global: `#F7F4EE` ou `#FAF8F3`
- surface: `#FFFFFF`
- surface secondaire: `#FBF7F0`
- bordure: `#E8DDCE`
- texte principal: `#171411`
- texte secondaire: `#6A5A4C`
- accent Maison216: `#B88A3B`
- succes: vert sobre
- alerte: ambre sobre
- erreur: rouge sobre

Regle:
- jamais de page admin entierement blanche
- jamais de carte KPI en gradient agressif
- jamais de contraste faible sur texte utile

### 3.0.5 Choix des composants par usage

Tables:
- demandes
- pages SEO
- logs simples
- utilisateurs si necessaire

Raison:
- l'utilisateur compare, filtre, trie et scanne.

Cartes:
- realisations avec image
- selection de pages assignees si faible volume
- raccourcis dashboard

Raison:
- l'image ou l'element visuel est central.

Listes:
- activite recente
- historique d'une demande
- notes internes

Raison:
- lecture temporelle.

Erreur structurelle:
- afficher un CRM de demandes en cartes
- afficher 40 pages SEO en cartes
- mettre des dropdowns permanents sur chaque ligne de table

### 3.0.6 Tables

Standards:
- header gris tres clair
- lignes 48-56px minimum
- hover discret
- pas de bordures verticales lourdes
- colonnes importantes toujours visibles
- actions rapides sobres en fin de ligne
- edition detaillee dans page detail, panneau lateral ou formulaire dedie

Pages & SEO - colonnes recommandees:
- Page
- Silo
- URL
- Meta title
- Meta description
- Indexation
- Realisations
- Derniere revision
- Actions

Demandes - colonnes recommandees:
- Date
- Type
- Nom
- Telephone
- Source
- Statut
- Priorite
- Actions

Realisations - affichage recommande:
- grille avec image pour la vue principale
- table possible en mode compact plus tard

### 3.0.7 Formulaires

Standards:
- label visible obligatoire
- placeholder facultatif, jamais seul
- aide de champ courte
- erreurs sous le champ
- focus stable en ring, sans deplacer le layout
- sections courtes avec titres explicites

Formulaire page SEO:
- Informations page, lecture seule: titre, URL, silo
- SEO editable: meta title, meta description, image OG, indexable
- Realisations assignees: module separe
- Canonical affiche en lecture seule si besoin, jamais editable

Formulaire settings:
- Identite
- Contact
- Reseaux sociaux
- SEO outils
- Assets

### 3.0.8 Badges et statuts

Badges:
- fond clair
- texte fonce
- point couleur si utile
- `white-space: nowrap`
- pas de badges multiligne

Statuts leads:
- Nouveau
- Contacte
- Qualifie
- Gagne
- Perdu
- Archive

Statuts realisations:
- Brouillon
- Publie

Statuts SEO:
- Complet
- Meta manquante
- Noindex
- Obsolete

### 3.0.9 Empty, loading, error, success

Chaque page doit prevoir:
- etat vide factuel
- loading stable ou skeleton
- error state avec action de recuperation
- success court, sans modal si confirmation simple
- cas 0, 1, 100 et 10 000 items

Exemples:
- `Aucune demande pour ce filtre.`
- `Aucune realisation assignee a cette page.`
- `Impossible de charger les demandes. Reessayer.`
- `Parametres enregistres.`

Interdit:
- modal de succes pour une sauvegarde simple
- empty state marketing long
- illustration decorative enorme sans action utile

### 3.0.10 Responsive admin

L'admin doit rester utilisable sur laptop en priorite.

Mobile:
- consultation possible
- actions simples possibles
- tables transformees en liste compacte uniquement si necessaire

Le mobile n'est pas le format principal pour gerer 40 pages SEO ou des galeries, mais il ne doit pas casser.

### 3.0.11 Performance d'interface

Standards:
- pagination serveur pour demandes
- recherche/filtres GET simples
- pas de chargement de toutes les images full-size dans l'admin
- thumbnails pour realisations
- upload avec preview
- pas de composants JS lourds inutiles

### 3.0.12 Definition visuelle de qualite

Une page admin Maison216 est consideree correcte si:
- elle a une action principale claire
- elle n'a pas de texte marketing
- elle affiche les informations critiques sans scroll excessif
- les statuts sont scannables
- les formulaires ne surprennent pas l'utilisateur
- les erreurs sont recuperables
- la page reste sobre et premium

### 3.1 Navigation admin cible

Menu principal:
- Tableau de bord
- Pages & SEO
- Realisations
- Demandes
- Parametres site
- SEO & outils
- Medias
- Archive ancien e-commerce, temporaire

Sous-menu Demandes:
- Toutes les demandes
- Demandes de devis
- Demandes professionnels
- Contact general

Archive ancien e-commerce:
- visible uniquement pendant transition
- contient produits / commandes si necessaire
- a retirer apres migration finale

### 3.2 Tableau de bord cible

KPIs:
- nouvelles demandes aujourd'hui
- demandes a traiter
- demandes professionnels
- pages sans meta description
- pages sans realisation assignee
- dernieres realisations ajoutees

Blocs:
- demandes recentes
- priorites SEO
- realisations recentes
- raccourcis: ajouter realisation, voir pages, voir demandes

## 4. Pages & SEO

### 4.1 Objectif

Donner a l'admin une vue claire de toutes les pages publiques du site, groupees par silo.

Chaque page doit afficher:
- silo
- URL publique
- titre admin
- meta title
- meta description
- statut indexable/noindex
- image OG
- nombre de realisations assignees
- date de derniere mise a jour SEO

### 4.2 Table cible `site_pages`

Champs recommandes:
- `id`
- `path` unique, exemple `aluminium/fenetre-aluminium`
- `silo`, exemple `aluminium`
- `parent_path` nullable
- `admin_title`
- `public_title`
- `description_snapshot`
- `meta_title`
- `meta_description`
- `og_image`
- `is_indexable` boolean
- `priority` decimal nullable pour sitemap
- `sort_order`
- `last_seo_reviewed_at`
- timestamps

Champs exclus volontairement:
- pas de `canonical_url`
- pas de scripts libres
- pas de contenu HTML libre

### 4.3 Synchronisation

Une commande ou action admin doit synchroniser `site_pages` depuis `config/site_structure.php`.

Regle:
- si une page existe dans config mais pas en DB, la creer
- si une page existe deja, ne pas ecraser ses metas admin
- si une page n'existe plus dans config, la marquer comme obsolete au lieu de la supprimer directement

## 5. Realisations

### 5.1 Objectif

Permettre a l'admin d'ajouter rapidement des realisations et de les afficher sur les pages publiques pertinentes.

### 5.2 Tables cibles

Table `realizations`:
- `id`
- `title`
- `slug`
- `project_type`
- `silo`
- `location`
- `short_description`
- `description` nullable
- `cover_image`
- `status` draft/published
- `is_featured`
- `completed_at` nullable
- `sort_order`
- timestamps

Table `realization_images`:
- `id`
- `realization_id`
- `image_path`
- `alt_text`
- `caption`
- `sort_order`
- timestamps

Table pivot `realization_site_page`:
- `realization_id`
- `site_page_id`
- `sort_order`
- `is_featured_on_page`

### 5.3 Regles d'affichage front

Sur chaque page publique:
- afficher les realisations assignees a cette page
- si aucune realisation assignee, fallback sur realisations du meme silo
- si aucune realisation du silo, fallback sur realisations globales publiees

### 5.4 Upload images

Stockage recommande:
- `storage/app/public/realizations`
- servir via `storage:link`

Regles:
- image de couverture obligatoire
- alt text recommande
- compression/resize a traiter plus tard si necessaire

## 6. Leads et demandes

### 6.1 Objectif

Toutes les demandes doivent etre stockees en base, pas seulement envoyees par email.

### 6.2 Table cible `leads`

Champs recommandes:
- `id`
- `type`: quote/professional/contact
- `source_page_path` nullable
- `source_url` nullable
- `name`
- `email`
- `phone`
- `company` nullable
- `profession` nullable
- `subject` nullable
- `message`
- `payload` json nullable
- `status`: new/contacted/qualified/won/lost/archived
- `priority`: low/normal/high
- `admin_notes` text nullable
- `last_contacted_at` nullable
- timestamps

### 6.3 Formulaires a connecter

Formulaires existants:
- contact
- espace professionnels
- devis

Chaque formulaire doit:
- creer un lead
- envoyer un email de notification aux emails admin
- garder un message de succes clair
- stocker la page source

### 6.4 Admin demandes

Fonctions minimum:
- liste avec filtres type/statut/date/source
- fiche detail demande
- changement de statut
- notes internes
- lien WhatsApp rapide
- lien email rapide

## 7. Parametres site

### 7.1 Groupes de parametres

Identite:
- nom du site
- baseline
- logo
- favicon
- image OG globale

Contact:
- telephone affichable
- numero WhatsApp
- email public
- emails de reception admin, liste simple
- adresse atelier
- ville atelier
- zone d'intervention

Reseaux sociaux:
- Facebook
- Instagram
- TikTok
- LinkedIn
- YouTube si necessaire

SEO outils:
- Google Search Console verification token
- Bing Webmaster verification token
- GA4 measurement ID, optionnel si decide plus tard
- pas de scripts libres

### 7.2 Front dynamique

Tout le front doit lire ces settings:
- topbar
- header
- footer
- pages contact/devis
- boutons WhatsApp
- emails affiches
- schema LocalBusiness

Plus aucun numero ou email hardcode ne doit rester dans les vues.

## 8. SEO technique

### 8.1 Meta resolution

Creer une couche de resolution SEO:
- lire la page depuis `site_pages`
- utiliser `meta_title` et `meta_description` si remplis
- fallback sur les metas code existantes
- canonical auto via `url()->current()` ou URL route propre
- robots selon `is_indexable`
- OG image page ou globale

### 8.2 Sitemap

Le sitemap doit inclure:
- les pages `site_pages` indexables
- exclure obsolete/noindex
- retirer progressivement les anciennes pages produits/categories si l'ancien e-commerce est supprime

### 8.3 Robots

Garder:
- `Disallow: /admin`
- sitemap dynamique

Ne pas exposer de configuration libre dangereuse en admin.

## 9. Nettoyage ancien modele e-commerce

### 9.1 Elements a retirer du menu admin

A retirer ou deplacer en archive temporaire:
- Produits
- Import JSON
- Categories e-commerce
- Architecture catalogue: rooms, product types, collections
- Commandes e-commerce

### 9.2 Routes front a retirer ou rediriger

Routes candidates:
- `/categories`
- `/c/{slug}`
- `/p/{slug}`
- `/checkout/{product}`
- `/checkout/success`
- `/order/quick`

Approche recommandee:
- rediriger vers pages strategiques utiles
- supprimer les liens publics
- retirer du sitemap
- supprimer les controleurs apres verification

### 9.3 Tables BDD candidates a supprimer plus tard

Tables e-commerce candidates:
- `products`
- `product_images`
- `categories`
- `orders`
- `order_items`
- `order_status_history`
- `rooms`
- `product_types`
- `catalog_collections`
- `collection_product`

Attention:
- certaines tables peuvent encore etre referencees par le code actuel
- suppression seulement apres retrait des routes, controleurs, vues et models dependants
- faire une migration destructive uniquement quand la nouvelle production est stable

## 10. Sprints d'implementation

### Sprint 1 - Plan, fondations admin et pages

Objectifs:
- creer ce document
- creer table `site_pages`
- creer modele `SitePage`
- creer commande de sync depuis `config/site_structure.php`
- creer admin `Pages & SEO`
- retirer edition canonical
- ajouter indicateur SEO incomplet

Validation:
- toutes les pages publiques visibles par silo dans admin
- meta title/description editables
- canonical non editable
- aucune injection script possible

### Sprint 2 - Parametres site dynamiques

Objectifs:
- enrichir settings admin
- ajouter telephone, WhatsApp, emails, adresse, reseaux sociaux, tokens Search Console/Bing
- remplacer les valeurs hardcodees front

Validation:
- changer telephone dans admin change topbar/header/footer/boutons WhatsApp
- changer email admin change notifications
- aucun champ script libre

### Sprint 3 - Leads

Objectifs:
- creer table `leads`
- connecter formulaires contact, devis, professionnels
- creer admin demandes
- envoyer emails de notification

Validation:
- chaque formulaire cree un lead en DB
- admin peut changer statut et ajouter notes
- emails continuent de partir

### Sprint 4 - Realisations

Objectifs:
- creer tables realisations/images/pivot pages
- creer CRUD admin realisations
- upload images
- assignation a pages
- rendre les sections realisations dynamiques

Validation:
- une realisation publiee apparait sur les pages assignees
- fallback par silo fonctionne
- images et alt text gerables

### Sprint 5 - Dashboard cockpit

Objectifs:
- remplacer dashboard e-commerce
- afficher KPIs leads/SEO/realisations
- ajouter raccourcis admin utiles

Validation:
- plus de KPI commandes/CA/produits au premier niveau
- priorites SEO visibles
- demandes recentes visibles

### Sprint 6 - Purge catalogue e-commerce obsolète

Objectifs:
- garder le module e-commerce en place
- ajouter une commande de purge controlee du catalogue
- vider produits, categories, images produits et images categories
- conserver les commandes en detachement propre des produits supprimes
- documenter les sauvegardes et la verification production

Validation:
- `catalog:purge --dry-run` affiche les compteurs sans changer les donnees
- `catalog:purge --force --backup --delete-files` cree une sauvegarde puis purge le catalogue
- `catalog:purge --force --backup --delete-orders` purge aussi commandes et lignes de commandes si demande par le proprietaire
- produits, images produits et categories sont a zero apres execution
- les commandes sont conservees ou supprimees selon option explicite
- les images hors catalogue restent presentes
- le module e-commerce reste disponible pour la future nouvelle strategie

## 11. Definition of Done globale

La refonte admin est consideree terminee quand:
- l'admin liste toutes les pages par silo
- chaque page a meta title/meta description editables
- canonical reste automatique
- aucun script libre n'est editable depuis admin
- les parametres site pilotent le front
- les demandes sont stockees en base et gerables
- les realisations sont uploadables et assignables aux pages
- les sections realisations publiques sont dynamiques
- l'ancien modele e-commerce est retire ou archive proprement
- le dashboard reflete le vrai business Maison216

## 12. Changelog sprint

### 2026-05-12 - Cadrage initial

Notes:
- decision confirmee: refonte admin vers cockpit site vitrine, SEO, leads et realisations
- decision confirmee: pas de champ scripts head/body dans l'admin
- decision confirmee: canonical automatique, non editable
- decision confirmee: nettoyer l'ancien modele e-commerce apres remplacement fonctionnel
- document cree avant implementation pour servir de reference de sprint
- doctrine UI/UX admin ajoutee: interface B2B sobre, operationnelle, sans discours marketing, avec tables pour CRM/pages SEO et cartes reservees aux realisations visuelles

Risques identifies:
- suppression trop rapide des tables e-commerce peut casser routes, sitemap ou anciennes vues
- les formulaires actuels envoient des emails mais ne stockent pas encore les leads
- les metas sont actuellement dans le code, il faut une couche DB avec fallback pour eviter les regressions SEO

Prochaine action recommandee:
- demarrer Sprint 1 avec `site_pages`, synchronisation depuis `config/site_structure.php`, admin Pages & SEO, et nouvelle navigation admin.

### 2026-05-12 - Sprint 1 demarre

Livres:
- migration `site_pages`
- modele `App\Models\SitePage`
- service `App\Support\SitePageSyncer`
- commande Artisan `site-pages:sync`
- routes admin `admin/site-pages`
- ecran admin `Pages & SEO` avec filtres, stats et edition meta
- canonical affiche en lecture seule, genere automatiquement
- layout admin remplace par un cockpit sobre avec archive e-commerce separee
- dashboard e-commerce remplace par un dashboard provisoire centre sur l'etat SEO des pages
- layout public connecte aux metas `site_pages` avec fallback code
- sitemap base sur `site_pages` quand la table est synchronisee

Verification locale:
- `php artisan migrate`
- `php artisan site-pages:sync`
- `php artisan route:list --path=admin/site-pages`
- `php artisan route:list --path=sitemap`
- `npm run build`
- `php artisan view:cache`
- `php artisan optimize:clear`

Resultat sync locale:
- 29 pages creees
- 0 pages obsoletes

Notes:
- l'ancien modele e-commerce n'est pas encore supprime physiquement
- il est isole dans le menu `Archive e-commerce`
- suppression destructive a garder pour Sprint 6 apres remplacement leads/realisations/settings

### 2026-05-12 - Regle de suivi sprint ajoutee

Notes:
- ajout d'une regle obligatoire de livraison des sprints
- chaque sprint doit mettre a jour ce fichier avant le message final
- chaque message final doit annoncer la prochaine etape prevue

Prochaine action recommandee:
- demarrer Sprint 2: parametres site dynamiques, telephone/WhatsApp/email/reseaux sociaux, tokens Search Console/Bing sans scripts libres, puis remplacement des valeurs hardcodees dans le front.

### 2026-05-12 - Sprint 2 livre: parametres site dynamiques

Livres:
- refonte complete de l'ecran `Parametres site`
- suppression de l'UI settings e-commerce: frais livraison, boutons checkout, discours boutique
- ajout des groupes Identite, Contact, Localisation, Reseaux sociaux, SEO & outils, Assets
- ajout du helper `App\Support\SiteSettings` pour centraliser telephone, WhatsApp, emails, adresse, logo, favicon
- topbar, header, footer, page contact, pages silos, pages projets, erreurs 404/500 et espace professionnels branches sur les settings dynamiques
- emails de notification contact et anciennes commandes branches sur la liste `Emails de reception`
- ajout des tokens Google Search Console et Bing Webmaster dans le layout public
- image OG globale configurable par URL/chemin ou upload
- seeder settings enrichi avec les valeurs Maison216 actuelles

Verification locale:
- `php -l app/Support/SiteSettings.php`
- `php -l app/Http/Controllers/Admin/SettingController.php`
- `php -l app/Http/Controllers/ContactController.php`
- `php -l app/Http/Controllers/ProductController.php`
- `php -l app/Services/OrderService.php`
- `php artisan optimize:clear`
- `php artisan view:cache`
- `php artisan route:list --path=admin/settings`
- `php artisan tinker --execute="dump([...])"` pour verifier telephone, WhatsApp et emails dynamiques
- `npm run build`
- `git diff --check`

Verification production:
- commit deploye: `05d441a0 Build dynamic site settings cockpit`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `npm ci`, `npm run build`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- HTTP smoke: `https://maison216.tn` retourne `200`
- URLs verifiees en `200`: `/`, `/contact`, `/partenaires`, `/menuiserie-bois`, `/aluminium`, `/fer-metal`, `/sur-mesure`
- `/admin/settings` retourne `302` vers `/login`, comportement attendu hors session admin
- verification contenu: topbar affiche `Atelier Maison216`, `Devis gratuit`, `Telephone/Whatsapp` et `96 813 203`
- verification serveur via Tinker: `SiteSettings::phoneDisplay()`, `SiteSettings::whatsappUrl()` et `SiteSettings::adminEmails()` retournent les valeurs attendues

Notes:
- aucun champ de script head/body n'a ete ajoute
- canonical reste genere automatiquement par le layout public
- les URL d'assets accepts en admin sont limitees aux URL http(s), chemins commencant par `/`, ou chemins relatifs sans schema dangereux
- les anciennes tables et routes e-commerce ne sont pas encore supprimees; elles restent dans l'archive jusqu'au sprint de nettoyage

Risques ou limites:
- les formulaires ne creent pas encore de leads en base; ils envoient encore des emails
- les realisations restent codees dans les vues publiques
- les anciens ecrans produits/commandes existent encore pour ne pas casser la production avant le nouveau CRM

Prochaine action recommandee:
- demarrer Sprint 3: creer la table `leads`, connecter les formulaires Contact, Devis et Espace professionnels, puis ajouter l'admin `Demandes` avec statuts et notes internes.

### 2026-05-13 - Sprint 3 livre localement: leads et demandes

Livres:
- migration `leads` avec champs type, source, contact, payload, statut, priorite, notes internes et date de dernier contact
- modele `App\Models\Lead` avec libelles de type/statut/priorite, scope demandes ouvertes et lien WhatsApp rapide
- service `App\Support\LeadCapture` pour transformer les formulaires publics en demandes stockees en base
- formulaire public `/devis` avec type de projet, localisation, message, telephone et CTA WhatsApp
- connexion des formulaires Contact, Devis et Espace professionnels a la table `leads`
- maintien des emails de notification vers les emails admin configures dans `Parametres site`
- admin `Demandes` avec liste table, filtres type/statut/priorite/recherche, stats, detail, changement de statut, priorite et notes internes
- menu admin mis a jour: `Demandes` devient une entree principale
- dashboard admin enrichi avec nouvelles demandes, demandes a traiter et demandes recentes

Verification locale:
- `php -l` sur la migration, le modele, le service et les controleurs modifies
- `php artisan route:list --path=admin/leads`
- `php artisan route:list --path=devis`
- `php artisan route:list --path=contact`
- `php artisan migrate`
- creation/suppression d'un lead test via `php artisan tinker`
- `php artisan view:cache`
- `npm run build`
- `php artisan optimize:clear`
- `php artisan migrate:status --path=database\migrations\2026_05_13_000001_create_leads_table.php`
- `git diff --check` sur les fichiers du sprint

Verification production:
- commit deploye: `f6a668ef Build leads admin cockpit`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `npm run build`, `php artisan migrate --force`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- migration serveur: `2026_05_13_000001_create_leads_table` en statut `Ran`
- routes serveur verifiees: `/devis` et `admin/leads`
- HTTP smoke: `https://maison216.tn/devis` retourne `200`
- verification contenu: la page `/devis` contient le formulaire et le bouton `Envoyer ma demande`
- `/admin/leads` retourne `302` vers `/login`, comportement attendu hors session admin
- verification serveur via Tinker: `App\Models\Lead::count()` retourne `0` avant les premieres demandes reelles

Notes:
- la premiere tentative de migration locale a revele une limite MySQL sur les index de chaines longues
- la migration a ete corrigee en limitant les longueurs des champs indexes (`type`, `status`, `priority`, `source_page_path`)
- le formulaire accepte maintenant email ou telephone, mais refuse une demande sans aucun moyen de contact
- le sprint cree le CRM minimum utile; il ne gere pas encore l'export, l'historique d'activite detaille ou les pieces jointes

Risques ou limites:
- les realisations restent codees dans les vues publiques
- les anciens ecrans produits/commandes restent encore dans l'archive e-commerce jusqu'au nettoyage final
- les demandes n'ont pas encore de pieces jointes pour plans/photos; a etudier apres stabilisation du cockpit

Prochaine action recommandee:
- demarrer Sprint 4: gestion complete des realisations, upload images, assignation aux pages, homepage incluse, puis remplacement des sections statiques publiques par des donnees admin.

### 2026-05-13 - Sprint 4 livre localement: realisations dynamiques

Livres:
- migration `realizations`, `realization_images` et table pivot `realization_site_page`
- modeles `App\Models\Realization` et `App\Models\RealizationImage`
- relation `SitePage::realizations()`
- resolver `App\Support\RealizationResolver` pour recuperer les realisations par page, par silo ou pour l'accueil, avec fallback avant migration
- admin `Realisations` avec liste visuelle, filtres, stats, creation, edition, suppression, upload image principale, galerie et assignation aux pages
- dashboard admin enrichi avec les realisations publiees et les dernieres realisations
- colonne `Realisations` ajoutee dans `Pages & SEO` pour voir combien de preuves sont assignees a chaque page
- seeder `RealizationSeeder` avec 6 realisations de depart basees sur les images existantes
- homepage branchee sur les realisations dynamiques
- hubs `Menuiserie bois`, `Menuiserie aluminium`, `Fabrication metallique` et `Sur mesure` branches sur les realisations dynamiques
- pages produits aluminium, metal et sur-mesure branchees sur les realisations dynamiques selon leur page ou silo
- pages projets, y compris immobilier neuf et cafe/restaurant, enrichies avec une section realisations dynamique
- partial public reutilisable `site-structure.partials.realization-showcase`

Verification locale:
- `php -l` sur migration, modeles, resolver, controleur admin, seeder et controleurs admin modifies
- `php artisan route:list --path=admin/realizations`
- `php artisan migrate`
- `php artisan site-pages:sync`
- `php artisan db:seed --class=RealizationSeeder`
- verification Tinker: `6` realisations, `6` publiees, `27` assignations pages
- `php artisan view:cache`
- `npm run build`
- `php artisan optimize:clear`

Verification production:
- commit deploye: `12aac4c2 Build realizations admin module`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `npm run build`, `php artisan migrate --force`, `php artisan storage:link`, `php artisan site-pages:sync`, `php artisan db:seed --class=RealizationSeeder --force`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- migration serveur: `2026_05_13_000002_create_realizations_tables` en statut `Ran`
- routes serveur verifiees: `admin/realizations`
- HTTP smoke: `https://maison216.tn` retourne `200`
- `/admin/realizations` retourne `302` vers `/login`, comportement attendu hors session admin
- URLs publiques verifiees en `200`: `/menuiserie-bois`, `/aluminium`, `/projets/agencement-cafe-restaurant`
- verification contenu homepage: section `Nos dernières réalisations` presente avec `Cuisine sur mesure` et `Dressing sur mesure`
- verification serveur via Tinker: `6` realisations, `6` publiees, `27` assignations pages

Notes:
- l'admin ne cree pas encore de pages detail de realisation; les realisations servent d'abord les sections portfolio sur les pages publiques
- les images seedees restent dans `public/assets/home/realizations`; les nouveaux uploads admin seront stockes dans le disque public Laravel
- le deploy serveur devra executer `php artisan storage:link` pour exposer les uploads admin
- les anciennes sections statiques ont ete remplacees par des donnees dynamiques ou par le resolver; quelques tableaux hardcodes de fallback restent volontairement dans les vues tant que la table peut etre absente avant migration

Risques ou limites:
- il faudra valider visuellement l'UX admin avec de vraies images uploadées apres production
- les realisations n'ont pas encore de tags avancés ni tri par drag-and-drop; l'ordre se gere par champ numerique
- les pieces jointes pour leads/devis restent hors scope de ce sprint

Prochaine action recommandee:
- deployer Sprint 4, verifier `/admin/realizations`, la homepage et plusieurs pages silos/projets, puis demarrer Sprint 5 sur le dashboard final du cockpit et la preparation du nettoyage e-commerce.

### 2026-05-13 - Correctifs Sprint 4 apres test admin

Problemes constates:
- le champ `Localisation` n'etait pas clair pour l'admin et n'avait pas de valeur operationnelle immediate
- les images uploadées via le disque `storage/public` etaient cassees en production car Plesk retournait `403` sur `/storage/...`
- les cartes de realisations publiques n'etaient pas cliquables
- les pages sans realisation assignée affichaient quand meme une section realisations vide ou alimentee par fallback

Correctifs livres:
- retrait du champ `Localisation` de l'admin realisations et du front realisations
- stockage des nouveaux uploads dans `public/uploads/realizations` pour eviter le probleme Plesk `/storage`
- compatibilite ajoutee pour les anciennes images `realizations/...` apres migration vers `public/uploads/realizations`
- ajout d'une page publique detail realisation: `/realisations/{slug}`
- cartes de realisations rendues cliquables sur homepage, silos, pages produits et pages projets
- sections realisations masquees automatiquement quand aucune realisation n'est assignee a la page
- boutons hero `Voir nos realisations` masques automatiquement quand la page n'a aucune realisation assignee
- sitemap enrichi avec les realisations publiees

Verification locale:
- `php -l` sur `Realization`, `RealizationResolver`, controleurs admin/public et seeder
- `php artisan route:list --path=realisations`
- `php artisan view:cache`
- `php artisan db:seed --class=RealizationSeeder`
- verification Tinker: URL detail realisation generee, homepage avec 6 realisations, page non assignee avec 0 realisation
- `npm run build`
- `php artisan optimize:clear`

Verification production:
- commit deploye: `84eb8ff6 Fix realizations UX and public detail pages`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: creation de `public/uploads/realizations`, migration des anciens fichiers si presents, mise a jour DB des chemins legacy, `npm run build`, `php artisan migrate --force`, `php artisan db:seed --class=RealizationSeeder --force`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- URL detail verifiee en `200`: `https://maison216.tn/realisations/cuisine-sur-mesure`
- homepage verifiee: les cartes pointent vers `/realisations/cuisine-sur-mesure`, `/realisations/dressing-sur-mesure`, `/realisations/volet-roulant-aluminium`, etc.
- resolver serveur verifie: `/aluminium/porte-aluminium` retourne `0` realisation assignee
- correction supplementaire ajoutee apres smoke test: les boutons hero vers `#realisations-*` disparaissent aussi quand la section n'existe pas
- correctif complementaire deploye: `d6ade0ec Hide realization CTAs when empty`
- verification serveur: `public/uploads/realizations` existe avec les droits du system user Plesk
- verification HTTP: `https://maison216.tn/realisations/cuisine-sur-mesure` retourne `200`
- verification homepage: `6` liens publics vers `/realisations/...` detectes
- verification page sans realisation: `/aluminium/porte-aluminium` ne contient plus ni lien `#realisations-aluminium`, ni section `id="realisations-aluminium"`

Note de deploiement:
- copier les fichiers existants de `storage/app/public/realizations` vers `public/uploads/realizations`
- mettre a jour les chemins DB `realizations/...` vers `uploads/realizations/...`
- relancer build et caches Laravel

Prochaine action recommandee:
- deployer ces correctifs, verifier l'image uploadée dans l'admin et l'URL detail `/realisations/cuisine-sur-mesure`, puis reprendre Sprint 5.

### 2026-05-13 - Correctifs UX page detail realisation

Correctifs livres:
- retrait du eyebrow silo dans le hero des pages detail realisation
- image a la une affichee avant le titre sur mobile pour donner plus de valeur visuelle a la page
- maintien du layout desktop texte + image, avec image a droite
- remplacement du libelle `WhatsApp` par le numero affiche configure dans les parametres site
- suppression de la section `Voir les services lies a cette realisation`

Verification locale:
- `php artisan view:cache`
- `php artisan route:list --path=realisations`

Verification production:
- commit deploye: `ef09fb21 Refine realization detail page UX`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `php artisan optimize:clear`, `php artisan view:cache`
- page verifiee: `https://maison216.tn/realisations/cuisine-sur-mesure`
- section `Voir les services lies a cette realisation` absente
- libelle texte `WhatsApp` absent des boutons; le numero `96 813 203` est affiche
- l'ancienne mention hero du silo n'est plus rendue dans le hero; les occurrences restantes de `Menuiserie bois` proviennent de la navigation globale et des meta keywords

Prochaine action recommandee:
- deployer le correctif, verifier mobile sur `/realisations/cuisine-sur-mesure`, puis reprendre Sprint 5 du cockpit admin.

### 2026-05-13 - Correctifs Pages & SEO: metas actuelles et OG upload

Problemes constates:
- les pages dans `Pages & SEO` etaient synchronisees depuis la structure de navigation, pas depuis les metas SEO reellement utilisees par le front
- les champs `meta_title` et `meta_description` pouvaient donc apparaitre vides alors que la page publique avait deja des metas codees
- l'image OG etait un champ URL, trop fragile et mauvais en UX
- l'accueil, les pages detail de realisation et les pages legales n'etaient pas listees dans `Pages & SEO`

Correctifs livres:
- ajout du resolver `SitePageSeoDefaults` pour centraliser les metas actuelles par page
- le sync `site-pages:sync` initialise maintenant `meta_title`, `meta_description` et `og_image` avec les valeurs actuelles du front
- les metas existantes modifiees par l'admin ne sont pas ecrasees apres revue SEO
- ajout de la page d'accueil dans `Pages & SEO`
- ajout des pages detail realisation publiees dans `Pages & SEO`
- ajout des pages legales dans `Pages & SEO`
- le layout public lit maintenant aussi les metas admin pour la page d'accueil
- remplacement du champ URL `Image OG` par un upload image avec preview et option de suppression
- stockage des uploads OG dans `public/uploads/site-pages/og` pour eviter les problemes Plesk `/storage`

Verification locale:
- `php -l` sur `SitePageSeoDefaults`, `SitePageSyncer`, `SitePage` et `Admin\SitePageController`
- `php artisan view:cache`
- `php artisan route:list --path=admin/site-pages`
- `php artisan site-pages:sync`
- verification Tinker: page accueil synchronisee, page `/aluminium` remplie avec son vrai meta title et sa vraie meta description, `6` pages realisations synchronisees, `0` meta title manquant

Verification production:
- commit deploye: `4ed5e209 Populate site page SEO defaults and OG uploads`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: creation de `public/uploads/site-pages/og`, `npm run build`, `php artisan site-pages:sync`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- sync serveur: `10` pages creees, `29` mises a jour, `39` pages au total
- verification serveur: `/aluminium` contient `Menuiserie aluminium en Tunisie | Atelier alu sur mesure`, sa vraie meta description actuelle et `assets/home/menuiserie-aluminium.jpg`
- verification serveur: page accueil synchronisee avec silo `site`
- verification serveur: `6` pages detail realisations synchronisees dans `Pages & SEO`
- verification serveur: `0` meta title manquant apres sync

Prochaine action recommandee:
- deployer, executer `php artisan site-pages:sync` en production, verifier `/admin/site-pages/2/edit`, puis reprendre Sprint 5 du cockpit admin.

### 2026-05-13 - Page publique Réalisations

Livres:
- ajout de la page portfolio publique `/realisations`
- ajout de la route `realizations.index`
- listing des realisations publiees avec filtres par silo et pagination
- cartes cliquables vers les pages detail `/realisations/{slug}`
- fil d'Ariane et schema `CollectionPage` pour la page portfolio
- ajout de `/realisations` dans `Pages & SEO` avec meta title, meta description et OG image par defaut
- mise a jour du footer: lien `Realisations` vers `/realisations`
- mise a jour du lien home `Voir toutes nos realisations` vers `/realisations`
- mise a jour des liens `Voir toutes nos realisations bois/alu/metal` vers `/realisations?silo=...`
- mise a jour des blocs projets utilisant le partial realisations pour pointer vers `/realisations?silo=projets`
- mise a jour du breadcrumb des pages detail realisation pour revenir vers `/realisations`

Verification locale:
- `php -l` sur `RealizationController`, `SitePageSyncer`, `SitePageSeoDefaults`
- `php artisan route:list --path=realisations`
- `php artisan view:cache`
- `php artisan site-pages:sync`
- verification Tinker: page `/realisations` creee dans `site_pages`, total `40` pages, `6` realisations publiees
- `npm run build`
- `git diff --check`

Verification production:
- commit deploye: `e541498d Add public realizations portfolio page`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `npm run build`, `php artisan site-pages:sync`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- sync serveur: `1` page creee, `35` mises a jour, `40` pages au total
- HTTP smoke: `https://maison216.tn/realisations` retourne `200`
- verification contenu: la page portfolio contient les realisations et `6` liens vers des pages detail `/realisations/...`
- verification home/footer: liens vers `https://maison216.tn/realisations` detectes
- verification serveur via Tinker: page `realisations` existe dans `site_pages`, silo `realisations`, type `portfolio`, meta title renseigne

Prochaine action recommandee:
- deployer, executer `php artisan site-pages:sync` en production, verifier `/realisations`, le footer et `/admin/site-pages`.

### 2026-05-13 - Correctif UI mobile page Realisations

Probleme constate:
- les filtres de la page `/realisations` se repliaient sur plusieurs lignes sur mobile, ce qui donnait une impression amateur et consommait trop d'espace avant les cartes
- les cartes portfolio utilisaient une image en `background-image`, moins propre pour l'accessibilite et le SEO image
- l'etat vide mentionnait l'admin, ce qui n'a pas sa place sur une page publique

Correctifs livres:
- filtre mobile transforme en rail horizontal sur une seule ligne, avec scroll tactile, chips `whitespace-nowrap` et `shrink-0`
- filtres plus compacts sur mobile et plus lisibles sur desktop
- ajout de compteurs en mini badges pour eviter les libelles lourds
- cartes realisations rendues plus premium: image HTML avec `alt`, hover zoom discret, overlay plus lisible, CTA `Voir le projet`
- etat vide public nettoye: plus aucune mention de l'admin

Verification locale:
- `php artisan route:list --path=realisations`
- `php artisan view:cache`
- `git diff --check -- resources/views/realizations/index.blade.php`
- `npm run build`

Verification production:
- commit deploye: `a37b9ca1 Refine realizations mobile portfolio UI`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `npm run build`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- HTTP smoke: `https://maison216.tn/realisations` retourne `200`
- verification HTML public: `overflow-x-auto`, `flex-nowrap`, `whitespace-nowrap` et les CTA `Voir le projet` sont presents
- verification serveur: la vue deployee contient bien `flex-nowrap`, `Voir le projet` et le nouvel etat vide public `Changez de filtre`

Remarques:
- le filtre desktop peut toujours se mettre sur plusieurs lignes si beaucoup de silos sont ajoutes plus tard; le probleme critique corrige ici est le rendu mobile
- la page reste sans JavaScript specifique, donc plus stable et plus rapide

Prochaine action recommandee:
- deployer ce correctif, verifier `/realisations` sur mobile, puis reprendre Sprint 5 du cockpit admin.

### 2026-05-14 - Correctif lisibilite images page Realisations

Probleme constate:
- les fichiers images de realisations existaient bien en production et repondaient en `200`
- le rendu des cartes noyait visuellement les photos dans un traitement sombre, donnant l'impression que les images ne chargeaient pas

Correctifs livres:
- remplacement des cartes plein fond sombre par une structure plus lisible: image visible en haut, contenu texte separe en bas
- conservation d'un petit label sur l'image avec voile leger uniquement en haut
- suppression du grand overlay sombre sur toute la photo
- maintien du CTA `Voir le projet`, du hover image et du layout mobile/desktop

Verification locale:
- `php artisan view:cache`
- `php artisan route:list --path=realisations`
- `git diff --check -- resources/views/realizations/index.blade.php`
- `npm run build`

Verification production:
- commit deploye: `098bd7fc Make realizations images visible`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `npm run build`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- HTTP smoke: `https://maison216.tn/realisations` retourne `200`
- verification HTML public: chaque carte contient une zone image `aspect-[1.28]` avec `img` en `object-cover`
- verification HTML public: l'ancien `background-image: linear-gradient` n'est plus present sur les cartes realisations
- verification images: les 6 URLs de realisations repondent en `200` avec `Content-Type` image

Prochaine action recommandee:
- deployer, verifier visuellement `/realisations` sur mobile et desktop, puis reprendre Sprint 5 du cockpit admin.

### 2026-05-14 - Correctif robuste affichage images portfolio

Probleme constate:
- apres le premier correctif, la page utilisait encore une zone image dependante de `aspect-[1.28]` et `h-full`
- sur le navigateur du client, les cartes continuaient a apparaitre comme de grands blocs sombres, donc l'image n'etait toujours pas suffisamment garantie visuellement

Correctifs livres:
- suppression de la dependance a `aspect-[1.28]`
- image affichee avec hauteur explicite responsive: `h-64`, `sm:h-72`, `lg:h-80`
- passage du panneau texte en fond blanc pour separer clairement image et contenu
- conservation du label sur image avec voile tres leger seulement en haut

Verification locale:
- `php artisan view:cache`
- `php artisan route:list --path=realisations`
- `git diff --check -- resources/views/realizations/index.blade.php`
- `npm run build`

Verification production:
- commit deploye: `787d1265 Use explicit realization image cards`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `npm run build`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- HTTP smoke: `https://maison216.tn/realisations` retourne `200`
- verification HTML public: les cartes utilisent `bg-white`, les images ont `block h-64 w-full object-cover`, et `aspect-[1.28]` n'est plus present
- verification images: les URLs testees repondent en `200` avec `Content-Type` image

Prochaine action recommandee:
- deployer ce correctif robuste, verifier avec hard refresh navigateur, puis reprendre Sprint 5 du cockpit admin.

### 2026-05-14 - Correctif global images lazy invisibles

Probleme constate:
- les images de la page `/realisations` etaient bien presentes dans le HTML et les URLs repondaient en `200`
- malgre les corrections de carte, le navigateur affichait seulement le fond beige
- cause racine trouvee dans `resources/css/custom.css`: `img[loading="lazy"] { opacity: 0; }`
- aucun script global ne rajoutait la classe `.loaded`, donc les images lazy restaient transparentes

Correctifs livres:
- remplacement de la regle globale par `img[loading="lazy"] { opacity: 1; }`
- conservation de la transition image sans masquer les photos
- correction applicable a toutes les images lazy du site, pas seulement `/realisations`

Verification locale:
- `npm run build`
- `php artisan view:cache`
- `git diff --check -- resources/css/custom.css docs/maison216-admin-cockpit-refactor-plan.md`

Verification production:
- commit deploye: `accdd4f9 Fix lazy image opacity`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `npm run build`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- HTTP smoke: `https://maison216.tn/realisations` retourne `200`
- verification HTML public: la page reference le nouveau build CSS `app-Czmsvrvw.css`
- verification CSS compile: `img[loading=lazy],img[loading=lazy].loaded{opacity:1}`

Prochaine action recommandee:
- deployer, verifier `/realisations` sans cache navigateur, puis reprendre Sprint 5 du cockpit admin.

### 2026-05-14 - Correctif libelles boutons WhatsApp

Probleme constate:
- plusieurs CTA publics affichaient encore un libelle generique `WhatsApp`, `WhatsApp atelier bois`, `WhatsApp direct` ou `WhatsApp professionnels`
- l'objectif UX est d'afficher directement le numero configure dans l'admin pour lever la friction et rendre le contact immediatement identifiable

Correctifs livres:
- remplacement des libelles de boutons WhatsApp par `SiteSettings::phoneDisplay()` sur les pages silos, pages produits, homepage, contact, devis, espace professionnels, header mobile, anciennes vues produit/checkout et CTA home legacy
- le lien reste toujours le lien WhatsApp dynamique configure dans les parametres site
- les textes explicatifs et labels de champs `Telephone / WhatsApp` sont conserves quand ils decrivent le canal ou le champ attendu

Verification locale:
- scan `rg` des anciens libelles de boutons hardcodes: aucun resultat
- `php -l app/Http/Controllers/SitePageController.php`
- `php artisan view:cache`
- `php artisan route:list --path=menuiserie-bois`
- `npm run build`
- `git diff --check` sur les fichiers modifies

Verification production:
- commit deploye: `47b84aaa Show phone number on WhatsApp CTAs`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `npm run build`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- pages verifiees: `/`, `/menuiserie-bois`, `/aluminium`, `/fer-metal`, `/sur-mesure`, `/devis`, `/contact`, `/partenaires`, `/projets/amenagement-exterieur`
- verification HTML: aucun ancien libelle `WhatsApp atelier`, `WhatsApp direct`, `WhatsApp professionnels`, `WhatsApp :` ou bouton `WhatsApp` seul detecte sur ces pages
- verification HTML: le numero `96 813 203` est present sur les pages testees
- verification serveur: aucun ancien libelle de bouton WhatsApp detecte dans `resources/views` et `app/Http/Controllers`

Prochaine action recommandee:
- deployer, verifier les CTA sur `/menuiserie-bois`, `/aluminium`, `/fer-metal`, `/sur-mesure`, `/devis`, `/contact` et `/partenaires`, puis reprendre Sprint 5 du cockpit admin.

### 2026-05-14 - Correctif global heroes publics

Probleme constate:
- les pages publiques affichaient encore des eyebrows dans les heroes (`Metier`, `Projet`, etc.)
- plusieurs images hero etaient traitees comme des cartes marketing avec textes superposes, voiles, badges ou effets
- sur mobile, le contenu textuel arrivait avant l'image ou l'image gardait des marges laterales, ce qui donnait une lecture moins premium

Correctifs livres:
- suppression des eyebrows dans les heroes de la homepage, silos metiers, pages produits aluminium, pages produits metal, pages sur mesure, pages projets, espace professionnels, devis, pages generiques et realisations
- remplacement des images hero avec background/overlay par de simples balises `img`, sans texte superpose ni badge
- ordre mobile standardise: image en premier, pleine largeur, sans marge laterale, puis H1, sous-titre, CTA et preuves
- boutons hero a deux CTA affiches sur une meme ligne en mobile avec tailles adaptees
- detail realisation ajuste pour valoriser l'image principale en premier sur mobile avec un rendu full width

Verification locale:
- `php artisan view:cache`
- `npm run build`
- `git diff --check` sur les templates modifies
- scan des restes `Metier ·` et `Projet ·` dans les templates publics: aucun resultat

Verification production:
- commit deploye: `f1871471 Simplify public heroes`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `npm run build`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- HTTP smoke: `https://maison216.tn/fer-metal/escalier-metallique` retourne `200`
- verification HTML production:
  - `/fer-metal/escalier-metallique` affiche une image hero simple avec `order-1 -mx-4`
  - `/aluminium/fenetre-aluminium` affiche une image hero simple avec `order-1 -mx-4`
  - `/partenaires` affiche une image hero simple avec `order-1 -mx-4`
  - anciens textes hero superposes (`Fabrication metallique`, `Fabrication aluminium`) absents des sorties verifiees

Prochaine action recommandee:
- verifier sur mobile `/fer-metal/escalier-metallique`, `/aluminium/fenetre-aluminium`, `/sur-mesure/cuisine-sur-mesure`, `/projets/agencement-cafe-restaurant`, `/partenaires` et une page detail realisation, puis reprendre Sprint 5 du cockpit admin.

### 2026-05-14 - Sprint 5 livre localement: dashboard cockpit

Diagnostic honnete:
- une premiere version du dashboard cockpit existait deja avant ce sprint
- elle n'etait pas e-commerce et affichait deja demandes, pages, metas manquantes et realisations
- elle restait incomplete par rapport au Sprint 5 du plan: pas assez de raccourcis operationnels, pas de suivi des pages sans realisation, pas de statut de livraison Sprint 5 dans ce document

Livres:
- dashboard admin finalise autour de 4 KPIs maximum: nouvelles demandes, demandes ouvertes, pages SEO a revoir, realisations publiees
- ajout d'actions rapides: synchroniser les pages, corriger les metas, creer/assigner une realisation, ouvrir les parametres publics
- ajout du bloc `Pages sans realisation` pour identifier les pages de service/projet sans preuve portfolio assignee
- amelioration des demandes recentes: type, statut, date et lien direct vers la fiche demande
- maintien du bloc `Pages SEO a completer` en table operationnelle
- maintien du bloc `Dernieres realisations` avec cartes visuelles et lien direct vers edition
- aucune commande, produit, chiffre d'affaires ou KPI e-commerce visible au premier niveau

Verification locale:
- `php -l app/Http/Controllers/Admin/DashboardController.php`
- `php artisan view:cache`
- `php artisan route:list --path=admin`
- `git diff --check -- app/Http/Controllers/Admin/DashboardController.php resources/views/admin/dashboard.blade.php`

Verification production:
- commit deploye: `f8efaaf9 Finalize admin cockpit dashboard`
- Plesk Git `--fetch`, verification du dernier commit, puis `--deploy`
- serveur: `npm run build`, `php artisan optimize:clear`, `php artisan config:cache`, `php artisan view:cache`
- verification route serveur: `admin.dashboard` pointe vers `Admin\DashboardController@index`
- verification vue deployee: blocs `Realisations publiees`, `Pages SEO a completer` et `Pages sans realisation` presents
- HTTP smoke: `https://maison216.tn/admin` retourne `302` vers `/login`, comportement attendu hors session admin

Remarques:
- Sprint 5 etait partiellement deja fait; il est maintenant complet selon le scope dashboard du plan
- le nettoyage des routes, vues, models et tables e-commerce reste hors Sprint 5 et appartient au Sprint 6

Prochaine action recommandee:
- deployer Sprint 5, verifier `/admin`, puis demarrer Sprint 6 par un audit des routes e-commerce encore actives avant toute suppression.

### 2026-05-14 - Sprint 6 redéfini: conservation e-commerce et purge catalogue

Decision proprietaire:
- le module e-commerce doit rester dans le projet
- l'ancien catalogue doit etre vide: produits, categories et images liees
- la nouvelle logique e-commerce sera definie plus tard

Livres localement:
- remplacement de l'ancienne commande dangereuse `reset:products` par une commande controlee `catalog:purge`
- ajout du mode `--dry-run` pour afficher les compteurs sans rien modifier
- ajout de `--backup` pour exporter les lignes impactees dans `storage/app/private/catalog-purge-backups`
- ajout de `--delete-files` pour supprimer les images locales de produits/categories uniquement
- couverture des dossiers images catalogue orphelins presents dans `public/images`, meme quand ils ne sont plus relies a une ligne produit
- detachement propre des anciennes commandes: `order_items.product_id` est mis a `null`, les commandes restent conservees
- nettoyage prevu du pivot `collection_product`
- conservation des tables, routes, controllers, vues et menus e-commerce pour la future strategie

Verification locale:
- `php -l app/Console/Commands/ResetProducts.php`
- `php artisan list` confirme la presence de `catalog:purge`
- `php artisan catalog:purge --dry-run`
- dry-run local constate apres correction: 4236 produits, 28001 images produit, 282 categories, 199 lignes de commande a detacher, 29044 fichiers image locaux trouves, 6530 dossiers image catalogue trouves
- `git diff --check -- app/Console/Commands/ResetProducts.php`

Verification production:
- commit deploye initial: `aec0ddf3 Add safe catalog purge command`
- dry-run production avant purge: 4236 produits, 28001 images produit, 282 categories, 199 lignes de commande a detacher, 29044 fichiers image locaux et 4210 dossiers image catalogue
- purge executee avec `catalog:purge --force --backup --delete-files`
- sauvegarde creee: `/var/www/vhosts/maison216.tn/httpdocs/storage/app/private/catalog-purge-backups/catalog-purge-20260514-114022.json` (24M)
- resultat premiere purge: produits 0, images produit 0, categories 0, commandes conservees 89, lignes de commandes conservees 199, liens produits commandes 0, images commandes 0
- commit correctif deploye: `67c9d984 Include orphan catalog images in purge`
- second dry-run production: 2318 dossiers catalogue orphelins restants dans `public/images`
- second passage execute avec `catalog:purge --force --delete-files`
- verification finale production: `public/images` vide, dossiers storage produits vides, homepage HTTP 200, `/categories` HTTP 200, `/admin` HTTP 302 vers login

Remarques:
- aucune purge locale definitive n'a ete executee pendant la validation
- la purge production doit etre executee apres deploiement de la commande, avec `--force --backup --delete-files`
- les assets publics hors catalogue ne sont pas vises par la commande
- les realisations, images home, logo et favicon ne doivent pas etre touches
- apres premiere purge production, 2318 dossiers orphelins restaient dans `public/images`; la commande a ete etendue et le second passage les a supprimes

Prochaine action recommandee:
- definir la nouvelle strategie e-commerce avant de recreer produits/categories: modele catalogue, types de produits, relation avec devis, affichage prix ou devis, et parcours admin minimal.

### 2026-05-14 - Correctif Sprint 6: purge commandes e-commerce demandee

Decision proprietaire:
- supprimer aussi les anciennes commandes e-commerce
- conserver le module e-commerce, mais repartir avec catalogue et commandes a zero

Livres localement:
- ajout de l'option `--delete-orders` a `catalog:purge`
- sauvegarde et purge couvrent maintenant `orders`, `order_items` et `order_status_history`
- les tables e-commerce restent en place

Verification locale:
- etat avant purge locale: 89 commandes, 199 lignes de commandes, 0 historique statut
- `php -l app/Console/Commands/ResetProducts.php`
- `php artisan catalog:purge --dry-run --delete-orders`

Verification production:
- commit deploye: `a78deb80 Allow purging ecommerce orders`
- dry-run production avant purge commandes: 89 commandes et 199 lignes de commandes a supprimer
- purge executee avec `catalog:purge --force --backup --delete-orders`
- sauvegarde creee: `/var/www/vhosts/maison216.tn/httpdocs/storage/app/private/catalog-purge-backups/catalog-purge-20260514-120240.json` (368K)
- verification finale production: produits 0, images produit 0, categories 0, commandes 0, lignes commandes 0, historique statut commandes 0
- HTTP smoke: homepage `200`, `/admin` `302` vers login

Prochaine action recommandee:
- definir la nouvelle strategie e-commerce avant de recreer produits/categories/commandes: modele catalogue, niveau de prix, parcours devis/panier, et cockpit admin associe.

### 2026-05-14 - Sprint Showroom 1: fondation e-commerce hybride

Decision proprietaire:
- conserver le noyau e-commerce Maison216
- transformer l'ancien catalogue en Showroom digital hybride
- accepter deux parcours produit: produit commandable avec checkout, produit sur devis sans checkout direct
- organiser le Showroom par activite professionnelle et non uniquement par categorie produit classique

Livres localement:
- ajout de la table `showroom_activities` pour les pages activite: pharmacies, CHR, beaute, boutiques, medical, bureaux, boulangeries, hotels
- ajout du pivot `product_showroom_activity` pour assigner un produit a une ou plusieurs activites
- extension des produits avec les champs Showroom:
  - prix nullable pour les produits sur devis
  - `is_starting_price`
  - `showroom_badge`
  - `availability_label`
  - `delivery_note`
  - `finish_summary`
  - `custom_options`
- ajout du modele `ShowroomActivity`
- ajout du `ShowroomActivitySeeder`
- ajout des routes publiques:
  - `/showroom`
  - `/showroom/{activite}`
  - `/showroom/produit/{slug}`
- ajout des vues publiques Showroom:
  - page principale Showroom
  - page activite avec filtre commandable / sur devis
  - fiche produit hybride
  - carte produit reutilisable
- ajout du lien `Showroom` dans le header public et dans le footer
- ajout du Showroom dans `config/site_structure.php` pour que la page racine soit connue du cockpit SEO
- ajout des URLs Showroom et produits actifs dans le sitemap
- adaptation de l'admin produits:
  - menu principal `Showroom`
  - assignation des produits aux activites Showroom
  - type de vente via `quote_only` + `sale_mode=sur_mesure`
  - prix optionnel si produit sur devis
  - champs disponibilite, livraison, finitions, badge, options JSON
  - affichage prix `Sur devis` / `A partir de ...`
  - lien admin vers la fiche `/showroom/produit/{slug}`
- blocage des achats directs pour les produits sur devis:
  - checkout redirige vers `/devis?produit=...`
  - commande rapide redirige aussi vers le devis
- correction de robustesse `Setting::get()` pour les environnements sans table `settings` pendant les tests

Verification locale:
- `php artisan migrate`
- `php artisan db:seed --class=ShowroomActivitySeeder`
- `php artisan route:list --path=showroom`
- `php artisan view:cache`
- `php artisan test` : 25 tests passes
- `npm run build`
- `git diff --check`

Remarques:
- les activites Showroom sont seedées mais pas encore administrables via une page CRUD dediee
- les produits ont ete purges en production precedemment; le Showroom sera donc vide jusqu'a creation/import de nouveaux produits
- le formulaire court produit sur devis n'est pas encore integre dans la fiche produit; le CTA redirige vers la page devis
- les anciennes routes e-commerce `/categories`, `/c/{slug}` et `/p/{slug}` sont conservees pour compatibilite, mais le nouveau parcours public prioritaire est `/showroom`
- correctif pre-cloture: l'etat vide public du Showroom ne pointe pas vers l'admin; il redirige vers le devis

Prochaine action recommandee:
- Sprint Showroom 2: creer l'administration des activites Showroom, ajouter un formulaire de demande de devis directement sur les fiches produits sur devis, puis creer/importer les premiers produits exemples par activite.

### 2026-05-14 - Correctif Sprint Showroom 1: nettoyage UI admin produit

Constat:
- l'ecran admin produit affichait encore des champs herites de l'ancien modele e-commerce
- champs visibles non alignes avec le brief Showroom: categorie, univers, type de produit, collection principale, collections associees, marque, SKU, mode de vente technique
- ces champs restent utiles techniquement pour compatibilite de la base, mais ne doivent pas polluer l'interface de travail

Livres localement:
- refonte de `admin/products/create` autour des champs Showroom demandes:
  - nom du produit
  - slug
  - type de vente: Produit commandable / Produit sur devis
  - prix, prix promotionnel, "A partir de"
  - image principale, galerie
  - description courte, description longue
  - activites concernees
  - materiaux, dimensions, finitions
  - options personnalisables JSON
  - disponibilite / stock
  - livraison
  - publication
- refonte de `admin/products/edit` avec la meme logique
- nettoyage de `admin/products/index`:
  - filtres limites a recherche, activite Showroom, type de vente, statut
  - colonne `Activites` au lieu de l'ancienne categorie
  - suppression visuelle de marque, univers, type, collection et SKU
  - lien de visualisation vers la fiche Showroom publique
- adaptation du controller admin:
  - ajout du slug editable
  - recherche admin sur titre et description courte
  - filtres activite Showroom et type de vente
  - `sale_mode=sur_mesure` mappe proprement vers produit sur devis

Verification locale:
- `php -l app/Http/Controllers/Admin/ProductController.php`
- `php artisan view:cache`
- `php artisan test` : 25 tests passes
- `git diff --check` sur les fichiers touches

Remarques:
- les anciennes colonnes BDD ne sont pas supprimees volontairement, pour ne pas casser le noyau e-commerce existant
- l'interface visible est maintenant alignee sur le module Showroom

Prochaine action recommandee:
- deployer ce correctif, puis demarrer Sprint Showroom 2: CRUD des activites, formulaire devis produit integre et premiers produits exemples.

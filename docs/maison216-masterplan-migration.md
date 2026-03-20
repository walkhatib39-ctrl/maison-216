# Maison 216 - Masterplan de migration produit, UX, catalogue et architecture

## 0. Statut du document

- Type: masterplan produit + cahier de charge + feuille de route de migration
- Portee: refonte strategique du site Maison 216, du catalogue, des parcours, de l'architecture de contenu, de l'UX, du design system et du modele de donnees
- Role: document de reference pour pilotage produit, cadrage UX/UI, priorisation technique, suivi d'avancement et arbitrage
- Reference existante: [project.md](../project.md) reste le snapshot de l'etat actuel du projet; ce document definit l'etat cible et la trajectoire de migration

## 1. Resume executif

Maison 216 ne doit pas devenir un simple site de meubles de plus en Tunisie, ni une copie cosmetique de Pickawood.

La position gagnante est la suivante:

**Maison 216 doit devenir une plateforme hybride de fabrication et vente d'amenagement interieur tunisien, permettant trois modes d'achat complementaires:**

1. acheter rapidement des produits prets et standardises
2. composer une piece a partir de modules compatibles
3. lancer un projet sur mesure avec accompagnement humain

Le site actuel est un e-commerce catalogue relativement classique, axe categories, produits et checkout.
Il fonctionne, mais il ne porte pas encore un avantage systemique.

La migration cible doit construire un veritable systeme produit autour de:

- l'intention client
- la compatibilite des modules
- la valorisation de l'atelier reel
- la confiance
- une experience d'entree premium, differenciante et tres claire

Le projet ne consiste donc pas a "refaire l'accueil".
Le projet consiste a **refondre le modele commercial et informationnel** du site, puis a faire de la homepage l'expression la plus nette de ce systeme.

## 2. Contexte business et these strategique

## 2.1 Realite du marche

Le marche meuble local est souvent structure autour de:

- catalogues classiques
- ensembles nommes
- pages categories generiques
- faible differenciation de parcours
- peu de mise en scene du savoir-faire reel

## 2.2 Avantages distinctifs reels de Maison 216

Maison 216 a un actif que beaucoup de concurrents n'ont pas ou n'exploitent pas bien:

- un atelier bois
- un atelier aluminium
- un atelier fer
- une capacite potentielle de standardisation partielle
- une capacite potentielle de sur mesure

Ce socle permet de construire une proposition plus riche que "vendre un lit", "vendre une chambre", ou "mettre un catalogue avec de jolies photos".

## 2.3 Positionnement cible

Maison 216 doit etre percue comme:

**le fabricant tunisien qui permet soit d'acheter des meubles prets, soit de composer intelligemment une piece, soit de lancer un projet sur mesure avec accompagnement**

Ce positionnement a quatre vertus:

- il differencie la marque
- il repond a plusieurs intentions d'achat
- il cree des pages SEO nombreuses sans tomber dans le spam
- il ouvre une voie claire pour l'evolution produit future

## 3. Diagnostic brutal de l'existant

## 3.1 Forces actuelles

- stack technique moderne et saine pour une V1
- arborescence categorie > produit deja en place
- admin fonctionnel pour produits, categories, commandes, settings
- import catalogue existant
- checkout simple et adapte au contexte local
- base de donnees exploitable pour une migration progressive
- identite Maison 216 deja installable

### Snapshot fonctionnel actuel

| Domaine | Etat actuel | Lecture strategique |
| --- | --- | --- |
| Front office | home, categories, produit, recherche, contact, checkout, commande rapide | base utile mais parcours encore trop catalogue |
| Admin | dashboard, produits, categories, commandes, settings, SEO placeholder | socle exploitable pour migrer sans reconstruire toute l'admin |
| SEO | categories, produits, sitemap, robots, quelques pages legales | bon point de depart, pas encore une machine editoriale |
| Commerce | COD, commande invite, WhatsApp, Messenger, livraison Tunisie | bien aligne avec le contexte local |
| Data | categories, products, product_images, orders, order_items, settings, users, order_status_history | schema propre pour V1, insuffisant pour bundles, collections et projets |
| Offre | produits standards et categories hiérarchiques | manque les couches collection, composition et sur mesure |
| UX | storefront moderne, mobile-first, categories visibles, produit detaille | design correct, mais pas encore memorisable ni systemique |

## 3.2 Faiblesses actuelles

- architecture d'offre trop catalogue, pas assez orientee intention
- homepage classique, belle mais encore interchangeable
- pas de systeme "composer" ou "sur mesure" structure
- pas de distinction claire entre produit standard, bundle et projet
- pas de couche "collection" exploitee comme moteur de parcours
- absence de moteur de compatibilite entre modules
- absence de back-office pour gerer bundles, templates, parcours guidés et demandes projets
- SEO encore principalement porte par categories et produits bruts

## 3.3 Risques si rien ne change

- banalisation face aux concurrents
- guerre de prix implicite
- faible memorisation de marque
- home jolie mais non differenciante
- incapacité a capitaliser sur l'atelier reel
- impossibilité d'industrialiser un futur configurateur

## 3.4 Risques si la migration est mal pensee

- trop de complexite front sans structure data
- configurateur libre ingérable
- promesses non tenables en production
- confusion entre e-commerce et devis
- cannibalisation SEO
- surcout technique sans impact business

## 4. Principes directeurs non negociables

1. Ne jamais penser page avant systeme.
2. Ne jamais promettre une personnalisation non industrialisee.
3. Ne jamais melanger sans distinction produit standard et projet sur mesure.
4. Ne jamais construire un configurateur total si les regles de compatibilite ne sont pas modeleees.
5. Ne jamais sacrifier la conversion rapide au profit du "wow".
6. Utiliser le design pour clarifier, orienter, rassurer et qualifier.
7. Faire de l'accueil une porte d'entree premium, pas une vitrine confuse.

## 5. Vision produit cible

## 5.1 Les trois modes d'achat

### Mode A - Achat rapide

Pour les visiteurs qui savent deja ce qu'ils veulent:

- lit
- commode
- armoire
- meuble TV
- table
- meuble de rangement

Objectif:

- consultation rapide
- prix clair
- photos fortes
- livraison
- checkout ou commande rapide

### Mode B - Composition guidee

Pour les visiteurs qui veulent "faire une piece coherente" sans partir de zero.

Exemples:

- composer une chambre adulte
- composer une chambre enfant
- composer un salon
- composer une cuisine modulaire
- composer un dressing

Objectif:

- rassurer
- filtrer
- rendre le choix plus intelligent
- augmenter le panier moyen

### Mode C - Projet sur mesure

Pour les demandes qui dependent des mesures, contraintes de chantier ou finitions specifiques.

Exemples:

- cuisine sur mesure
- dressing sur mesure
- verriere
- garde-corps
- placard sous pente
- aluminium
- ferronnerie

Objectif:

- capturer un lead qualifie
- cadrer le projet
- orienter vers devis / RDV / WhatsApp / visite technique

## 5.2 Ce qu'il faut garder du modele classique

Il ne faut pas supprimer:

- les categories mères
- les sous-categories
- les produits individuels
- les pages collection

Il faut les **reclasser dans un systeme plus riche**.

## 5.3 Ce qu'il faut ajouter

- collections comme familles esthetiques
- bundles / compositions pretes
- templates de composition
- pages "composer"
- pages "projet sur mesure"
- preuve atelier / realisations / process
- copywriting a forte clarte commerciale

## 6. Architecture de l'offre cible

## 6.1 Niveaux d'organisation

Le catalogue cible doit etre structure selon six couches.

### Couche 1 - Univers / piece

- chambre adulte
- chambre enfant
- salon et sejour
- cuisine et rangement
- bureau
- exterieur si pertinent
- travaux et sur mesure

### Couche 2 - Type de meuble

- lit
- armoire
- dressing
- commode
- table de nuit
- meuble TV
- bibliotheque
- etagere
- table
- table basse
- meuble bas cuisine
- meuble haut cuisine
- colonne cuisine

### Couche 3 - Collection

La collection ne remplace pas la categorie.
Elle represente une coherence esthetique et marchande.

Exemples:

- collection Lora
- collection Kent
- collection Sarra

Une collection peut contenir:

- plusieurs produits individuels
- plusieurs types de meuble
- des bundles preconfigures

### Couche 4 - Bundle / composition

Une composition est une combinaison vendable:

- chambre 3 pieces
- chambre 5 pieces
- salon TV + table basse + bahut
- set bureau + rangement

### Couche 5 - Template de composition guidee

Ce n'est pas un produit.
C'est un parcours de configuration simplifie.

Exemples:

- composer ma chambre adulte
- composer mon dressing
- composer ma cuisine modulaire

### Couche 6 - Projet sur mesure

Ce n'est pas un produit panier standard.
C'est un flux de qualification.

## 7. Ce qu'il ne faut pas faire

## 7.1 Erreur 1 - Tout vendre uniquement par pieces

Ce serait une erreur.
Tu perds:

- les clients qui veulent une solution rapide
- le panier moyen des ensembles
- la lisibilite commerciale

## 7.2 Erreur 2 - Faire un configurateur 3D complet trop tot

Ce serait une dette enorme.
Sans:

- regles de compatibilite
- moteurs de prix
- standardisation des dimensions
- process atelier
- back-office solide

le 3D serait du theatre.

## 7.3 Erreur 3 - Mettre aluminium, fer et meubles dans le meme tunnel

L'intention n'est pas la meme.
Il faut unifier la marque, pas fusionner les parcours.

## 8. Architecture d'information cible du site

## 8.1 Navigation principale

Navigation desktop cible:

- Decouvrir
- Composer
- Sur mesure
- Realisations
- Conseil et RDV
- Promotions

## 8.2 Mega-menu "Decouvrir"

Entrée par univers:

- chambre adulte
- chambre enfant
- salon et sejour
- cuisine et rangement
- bureau
- deco et rangements complementaires

Dans chaque univers:

- categories principales
- sous-categories
- collections
- compositions pretes
- page "tout voir"

## 8.3 Menu "Composer"

Entrées ciblees:

- composer une chambre adulte
- composer une chambre enfant
- composer un salon
- composer un dressing
- composer une cuisine modulaire
- concevoir un meuble TV

## 8.4 Menu "Sur mesure"

Entrées par metier et par besoin:

- cuisine sur mesure
- dressing sur mesure
- meuble TV sur mesure
- placard sous pente
- aluminium
- ferronnerie
- verrieres et separations
- prise de RDV

## 8.5 Architecture d'URL cible

Exemples:

- `/chambre-adulte/`
- `/chambre-adulte/lits/`
- `/chambre-adulte/armoires-dressings/`
- `/chambre-adulte/commodes/`
- `/collections/lora/`
- `/compositions/chambre-adulte-4-elements-lora/`
- `/composer/chambre-adulte/`
- `/sur-mesure/cuisine/`
- `/sur-mesure/dressing/`
- `/realisations/chambre-adulte/`
- `/guides/comment-choisir-un-dressing-en-tunisie/`

## 9. Pages cibles a produire

## 9.1 Homepage

Role:

- premiere impression
- orientation
- credibilite
- qualification

## 9.2 Landing page univers

Exemples:

- chambre adulte
- chambre enfant
- salon
- cuisine et rangement

## 9.3 Landing page sous-categorie

Exemples:

- lits
- armoires
- dressings
- bibliotheques

## 9.4 Page collection

Role:

- vendre un style
- regrouper des pieces coherentes
- proposer des ensembles et des pieces

## 9.5 Page composition prete

Role:

- convertir rapidement
- rassurer sur la coherence
- pousser l'upsell

## 9.6 Page "composer"

Role:

- guider
- filtrer
- construire un panier ou une demande

## 9.7 Page projet sur mesure

Role:

- capter un lead
- qualifier le besoin
- lancer le processus commercial

## 9.8 Page realisations

Role:

- preuve
- desir
- confiance

## 9.9 Page guide / inspiration

Role:

- SEO
- education
- assistance a la decision

## 10. Vision homepage detaillee

## 10.1 Objectifs prioritaires de la homepage

1. faire comprendre la proposition de valeur en 5 secondes
2. montrer que Maison 216 est un vrai fabricant
3. proposer plusieurs portes d'entree claires
4. sortir du cadre catalogue classique
5. servir la conversion, pas juste l'image

## 10.2 Structure cible recommandeee

### Bloc 1 - Hero signature

Contenu:

- message principal tres fort
- promesse double: composer ou commander
- visuel premium, pas banal
- CTA primaire: `Composer ma piece`
- CTA secondaire: `Voir les collections`
- CTA tertiaire: `Demander un devis`

Exemple de direction copy:

- "Composez votre interieur, element par element."
- "Des meubles prets, des compositions coherentes, et des projets sur mesure fabriques en Tunisie."

### Bloc 2 - Choisissez votre mode

Trois cartes:

- acheter par element
- composer une piece
- lancer un projet sur mesure

### Bloc 3 - Univers Maison 216

Grille editoriale premium:

- chambre adulte
- chambre enfant
- salon et sejour
- cuisine et rangement
- bureau
- sur mesure

### Bloc 4 - Composez en quelques clics

Cartes de parcours:

- composer une chambre
- composer un dressing
- composer un meuble TV
- composer une cuisine modulaire
- lancer un projet alu
- lancer un projet ferronnerie

### Bloc 5 - Collections et compositions

Deux voies:

- collections signature
- compositions pretes a acheter

### Bloc 6 - L'atelier comme preuve

Blocs de credibilite:

- bois
- aluminium
- fer
- livraison Tunisie
- pose si applicable
- delais
- accompagnement

### Bloc 7 - Realisations

Avant / apres, chantiers reels, pieces finies.

### Bloc 8 - Best-sellers / nouveautes

Pas comme premier bloc.
Pas comme coeur de proposition.
Seulement comme preuve commerciale.

### Bloc 9 - Contenus et inspiration

- guides
- idees d'amenagement
- choix des dimensions
- conseils de materiaux

## 10.3 Ce que la homepage ne doit pas devenir

- un supermarche d'images
- un patchwork de sections sans logique
- une copie visuelle de Pickawood
- un hero vide avec slogan abstrait

## 11. Parcours utilisateurs cibles

## 11.1 Parcours A - Achat rapide d'un produit standard

1. entree home ou SEO categorie
2. arrivee sur univers ou sous-categorie
3. filtre par style / budget / dimension
4. consultation fiche produit
5. ajout panier ou commande rapide
6. confirmation

## 11.2 Parcours B - Composition guidee

1. entree home ou page "composer"
2. choix de la piece
3. choix du style ou collection
4. choix des modules obligatoires et optionnels
5. choix dimensions et finitions si standardisees
6. recapitulatif
7. panier, WhatsApp ou devis selon complexite

## 11.3 Parcours C - Projet sur mesure

1. entree depuis home, SEO ou realisations
2. page projet avec exemples et promesses
3. formulaire qualifiant
4. upload photo / plan / dimensions
5. choix gouvernorat / ville / budget / delai
6. WhatsApp, RDV ou devis

## 11.4 Parcours D - Mobile-first conversationnel

Dans le contexte tunisien, il faut assumer que beaucoup de visiteurs veulent:

- une verification humaine
- un contact rapide
- une reponse WhatsApp

Chaque parcours doit donc pouvoir bifurquer vers:

- WhatsApp
- formulaire
- rappel
- devis

## 12. Regles UX fondamentales

## 12.1 Le configurateur ne doit jamais etre une page vide

Toujours offrir:

- des templates
- des points de depart
- des exemples
- des presets

## 12.2 La personnalisation doit etre guidee

Ordre recommande:

1. choisir un archetype
2. choisir les dimensions
3. choisir le style
4. choisir les modules
5. choisir les finitions

## 12.3 Le prix doit rester compréhensible

Il faut afficher:

- prix de base
- supplement de modules
- options
- fourchette si sur mesure

## 12.4 Le client doit toujours savoir quoi faire ensuite

Les pages doivent mener vers:

- ajouter au panier
- composer
- demander un devis
- parler a un conseiller

## 13. Direction design system

## 13.1 Direction generale

Le design cible doit etre:

- premium
- sobre
- contemporain
- architectural
- chaleureux
- sans effet "template"

## 13.2 Ce qu'il faut eviter

- look marketplace generique
- hero plein ecran vide de sens
- cartes monotones sans hierarchie
- interface purple-tech sans rapport avec le metier
- sur-animation decorative

## 13.3 Principes visuels

- typographie forte et editoriale
- grand usage de l'espace blanc
- blocs structurels nets
- visuels produits et realisations tres soigneusement cadrees
- palette chaude et materielle
- contrastes nets entre contenu commercial et contenu atelier

## 13.4 Composants majeurs

- hero systemique
- cartes univers
- cartes parcours
- cards collection
- cards composition
- carrousel realisations
- bandeaux de preuve
- mega-menu editorial
- stepper de composition
- recap sticky

## 13.5 Mobile

La version mobile n'est pas une reduction.
Elle doit etre un parcours prioritaire.

Priorites mobile:

- CTA visibles
- mega-menu simplifie
- parcours "composer" compact
- recap sticky
- contacts rapides

## 14. Direction copywriting

## 14.1 Tonalite

Le ton Maison 216 doit etre:

- expert
- clair
- confiant
- sobre
- jamais grandiloquent
- jamais pseudo-luxe creux

## 14.2 Grammaire de marque

Verbes dominants:

- composer
- amenager
- choisir
- personnaliser
- fabriquer
- concevoir
- demander

## 14.3 Formules a privilegier

- "Composez votre chambre"
- "Choisissez vos elements"
- "Lancez votre projet sur mesure"
- "Fabrique dans nos ateliers"
- "Demandez une estimation"
- "Voir les compositions"

## 14.4 Formules a eviter

- "Le meuble de vos reves" en boucle
- "Excellence" sans preuve
- "Qualite premium" sans details
- slogans abstraits sans CTA concret

## 14.5 Microcopy systemique

Exemples:

- bouton: `Composer ma chambre`
- bouton: `Voir les modules`
- bouton: `Recevoir une estimation`
- aide: `Commencez par un style, nous filtrerons les modules compatibles.`
- aide: `Projet complexe ? Envoyez une photo ou vos dimensions.`

## 15. Strategie SEO cible

## 15.1 Pages a indexer

- home
- univers
- sous-categories
- collections
- produits
- compositions pretes
- pages sur mesure
- realisations
- guides

## 15.2 Pages a ne pas laisser indexer massivement

- pages filtrees combinatoires
- etapes internes du builder
- pages panier / recap intermediaire

## 15.3 Strategie de contenus

Produire des pages de valeur reelle:

- comment choisir un dressing
- difference entre armoire et dressing
- comment composer une chambre adulte
- idees cuisine modulaire Tunisie
- prix d'un meuble TV sur mesure en Tunisie

## 15.4 SEO et architecture

Le builder ne fera pas seul le SEO.
Le builder sert la conversion.
Le SEO sera porte par:

- landings univers
- sous-categories
- collections
- pages sur mesure
- realisations
- guides

## 16. Migration fonctionnelle du catalogue

## 16.1 Donnees actuelles a conserver

- categories
- products
- product_images
- orders
- order_items
- settings
- users
- order_status_history

### Cartographie de la base actuelle

| Table actuelle | Role actuel | Sort en migration |
| --- | --- | --- |
| `categories` | taxonomie SEO et navigation | a conserver et enrichir |
| `products` | coeur catalogue standard | a conserver et etendre fortement |
| `product_images` | galerie visuelle | a conserver |
| `orders` | commande client | a conserver |
| `order_items` | snapshot ligne commande | a conserver |
| `settings` | configuration site et contact | a conserver |
| `users` | auth et admin | a conserver |
| `order_status_history` | suivi de statut | a conserver |
| `cache`, `jobs` | technique Laravel | hors scope produit mais inchanges |

## 16.2 Donnees a introduire

### Nouvelles entites coeur

- rooms
- product_types
- collections
- collection_product
- bundles
- bundle_items
- builder_templates
- builder_template_steps
- builder_template_options
- product_dimensions
- materials
- finishes
- product_material
- product_finish
- compatibility_rules
- project_request_types
- project_requests
- project_request_attachments
- inspirations
- landing_pages

### Entites optionnelles mais fortement recommandees

- testimonials
- realizations
- realization_images
- quote_requests
- lead_sources
- seo_pages

## 16.3 Logique metier cible

Un produit doit pouvoir etre:

- standard
- configurable leger
- element d'un bundle
- rattache a une collection
- rattache a un univers
- rattache a un type de meuble

Un bundle doit pouvoir:

- regrouper plusieurs produits
- porter un prix de reference ou un calcul dynamique
- appartenir a une collection
- etre expose comme composition prete

Un template de builder doit pouvoir:

- definir un parcours
- imposer des choix
- limiter les combinaisons
- calculer une estimation

Une demande projet doit pouvoir:

- definir un type de besoin
- stocker dimensions
- stocker budget
- stocker gouvernorat / ville
- stocker medias
- etre suivie dans un pipeline commercial

## 16.4 Evolution minimale du schema existant

### Table `products`

Champs a ajouter:

- `product_type_id`
- `room_id`
- `collection_id` nullable si relation directe utile
- `sale_mode` enum: standard, configurable, quote_only
- `is_featured`
- `lead_time_days_min`
- `lead_time_days_max`
- `assembly_required`
- `material_summary`
- `dimension_summary`

### Table `categories`

Champs possibles:

- `room_id`
- `category_kind` enum: universe, type, seo, support
- `landing_intro`
- `landing_outro`

## 16.5 Modele de compatibilite

Le systeme doit pouvoir dire:

- quels modules vont ensemble
- quelles collections peuvent cohabiter
- quelles dimensions sont compatibles
- quels produits sont obligatoires ou optionnels dans un parcours

Sans ce modele, il n'y a pas de "composer" credible.

## 17. Exigences back-office

Le back-office cible devra permettre:

- gerer les univers
- gerer les types de meuble
- gerer les collections
- gerer les bundles
- gerer les templates de builder
- definir des options et compatibilites
- gerer les pages landing
- gerer les demandes projet
- gerer les realisations et inspirations

## 18. Strategie technique de mise en oeuvre

## 18.1 Principe de migration

Migration incrementale, pas big bang.

Le systeme actuel doit rester vendable pendant la transformation.

## 18.2 Phases techniques conseillees

### Phase 0 - Cadrage et nettoyage

- audit catalogue
- audit categories
- normalisation slugs
- inventaire collections implicites
- definition taxonomie cible

### Phase 1 - Fondations data

- tables univers / types / collections
- rattachement produits
- seeds / admin de gestion

### Phase 2 - Front structurel

- nouvelle homepage
- nouveau mega-menu
- nouvelles pages univers
- nouvelles pages collection
- nouvelles pages composition prete

### Phase 3 - Builder guide MVP

- "composer une chambre"
- templates
- recap
- estimation
- sortie panier ou devis

### Phase 4 - Sur mesure industrialise

- pages projet
- formulaires qualifies
- pipeline admin
- pieces jointes

### Phase 5 - Optimisation

- analytics
- AB tests
- version mobile avancee
- recommandations

## 18.3 Ce qu'il ne faut pas construire en phase 1

- configurateur 3D complet
- moteur de rendu photorealiste
- systeme de prix ultra-complexe
- personalisation infinie

## 19. Roadmap produit detaillee

## 19.1 Chantier A - Strategie catalogue

Livrables:

- taxonomie finale
- mapping categories actuelles > univers / types / collections
- regles de nommage
- regles SEO

## 19.2 Chantier B - Experience d'entree

Livrables:

- nouvelle homepage
- nouvelle navigation
- systeme editorial hero + cartes univers + cartes parcours

## 19.3 Chantier C - Pages coeur business

Livrables:

- univers
- sous-categories
- collections
- compositions
- pages sur mesure

## 19.4 Chantier D - Builder guide

Livrables:

- parcours chambre adulte
- templates
- recap
- CTA panier / devis / WhatsApp

## 19.5 Chantier E - Admin et operations

Livrables:

- gestion collections
- gestion bundles
- gestion demandes projet
- suivi pipeline

## 20. KPIs cibles

KPIs business:

- taux de conversion global
- taux de conversion mobile
- panier moyen
- taux de demande de devis
- taux de conversion WhatsApp
- taux de composition terminee
- attach rate des bundles

KPIs UX:

- CTR hero
- CTR vers "Composer"
- progression et drop-off par etape
- taux de sortie avant recap
- temps moyen jusqu'au CTA

KPIs SEO:

- trafic organique par univers
- trafic organique par sous-categorie
- trafic organique par collection
- trafic organique par page sur mesure
- positionnement sur intentions coeur

## 21. Risques et mitigations

## 21.1 Risque - Complexite trop ambitieuse

Mitigation:

- builder guide MVP
- phase 3 seulement apres fondations data

## 21.2 Risque - Catalogue incoherent

Mitigation:

- taxonomie d'abord
- mapping catalogue rigoureux

## 21.3 Risque - UX belle mais impraticable

Mitigation:

- partir des intentions utilisateur
- tester mobile d'abord

## 21.4 Risque - Trop de pages SEO faibles

Mitigation:

- indexer seulement les pages utiles
- produire des contenus editoriaux solides

## 22. Definition of done du programme de migration

La migration sera consideree comme reussie quand:

- la homepage exprime clairement les 3 modes d'achat
- la navigation est orientee intention et non chaos catalogue
- les univers ont chacun leurs pages dediees
- les collections sont valorisees sans cannibaliser les categories
- les compositions pretes existent et convertissent
- un premier builder guide est operationnel
- le sur mesure dispose d'un vrai funnel de qualification
- l'admin sait gerer les nouvelles couches du catalogue
- les KPIs sont mesures

## 23. Liste des decisions structurantes

### Decision 1

Maison 216 devient une marque hybride `catalogue + composition + sur mesure`.

### Decision 2

Les ensembles nommes ne sont pas supprimes; ils deviennent des collections et/ou bundles.

### Decision 3

Le builder initial est guide et contraint, pas libre et total.

### Decision 4

Le sur mesure est un tunnel de qualification, pas un faux panier classique.

### Decision 5

L'accueil est redesigné comme interface de tri des intentions, pas comme vitrine catalogue.

## 24. Prochaine etape recommandee

Avant toute implementation UI, produire les trois livrables suivants:

1. taxonomie cible complete
   Reference: [Annexe A - Taxonomie cible](./annexe-a-taxonomie-cible.md)
2. schema de donnees cible minimal
   Reference: [Annexe B - Modele de donnees cible](./annexe-b-modele-donnees-cible.md)
3. wireframe structurel de la homepage et des pages univers
   Reference: [Annexe C - Wireframes structurels](./annexe-c-wireframes-structurels.md)

## 25. Annexes de travail a produire ensuite

- annexe A: taxonomie univers / types / collections
- annexe B: modele relationnel detaille
- annexe C: wireframes low-fidelity
- annexe D: systeme de copywriting
- annexe E: backlog Jira / Notion / Trello decoupe par phases

### Etat actuel des annexes

- [Annexe A - Taxonomie cible](./annexe-a-taxonomie-cible.md)
- [Annexe B - Modele de donnees cible](./annexe-b-modele-donnees-cible.md)
- [Annexe C - Wireframes structurels](./annexe-c-wireframes-structurels.md)
- [Annexe D - Copywriting system](./annexe-d-copywriting-system.md)
- [Annexe E - Backlog phase](./annexe-e-backlog-phase.md)

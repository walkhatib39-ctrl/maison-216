# Annexe E - Backlog phase et feuille de route d'execution

## 1. Role de cette annexe

Cette annexe transforme le masterplan en sequence executable.

Elle sert a:

- decouper le programme
- prioriser ce qui cree de la valeur
- eviter les chantiers paralleles inutiles
- definir les livrables, dependances et criteres de fin

## 2. Regles de priorisation

Ordre de priorite absolu:

1. architecture offre et data
2. navigation et pages coeur
3. builder guide MVP
4. sur mesure qualifie
5. optimisation et sophistication

Ce qui ne doit pas arriver:

- lancer un configurateur avant la taxonomie
- lancer une grosse refonte UI avant les parcours
- lancer un back-office bundles avant d'avoir decide ce qu'est un bundle

## 3. Vue d'ensemble des phases

Le programme est organise en 7 phases:

0. cadrage et audit
1. fondations taxonomie et data
2. navigation et experience d'entree
3. pages commerciales coeur
4. builder guide MVP
5. sur mesure et lead management
6. optimisation, SEO, analytics

## 4. Phase 0 - Cadrage et audit

## 4.1 Objectif

Figer les decisions structurantes avant toute implementation majeure.

## 4.2 Livrables

- masterplan valide
- annexe taxonomie validee
- annexe data validee
- annexe wireframes validee
- annexe copywriting validee

## 4.3 Taches

- inventaire categories existantes
- inventaire types de produits reels
- inventaire collections commerciales existantes
- inventaire offres vendables en bundle
- inventaire projets sur mesure reels
- validation nomenclature

## 4.4 Criteres de sortie

- la structure `univers / types / collections / bundles / sur mesure` est tranchee
- les pages MVP sont listees
- les chantiers suivants ont des dependances claires

## 5. Phase 1 - Fondations taxonomie et data

## 5.1 Objectif

Permettre la mutation du catalogue sans casser la prod.

## 5.2 Chantier base de donnees

### Taches backend

- creer table `rooms`
- creer table `product_types`
- creer table `collections`
- creer pivot `collection_product`
- enrichir `products`
- enrichir `categories`

### Taches de migration data

- mapper chaque categorie existante a un univers
- scinder `Chambre` en deux axes cibles
- identifier les produits enfant vs adulte
- initialiser les premiers `product_types`

## 5.3 Chantier admin minimal

- ecran de gestion des univers
- ecran de gestion des types de meuble
- ecran de gestion des collections
- affectation produit > type > collection

## 5.4 Criteres de sortie

- tous les produits sont rattachables a un univers et un type
- les collections peuvent etre gerees
- aucun flux existant catalogue n'est casse

## 6. Phase 2 - Navigation et experience d'entree

## 6.1 Objectif

Refondre la porte d'entree du site autour des intentions.

## 6.2 Chantier UX/UI

- nouveau header
- nouveau mega-menu
- nouveau menu mobile
- nouvelle homepage structurelle

## 6.3 Chantier contenu

- hero de marque
- bloc 3 modes d'achat
- blocs univers
- blocs `composer`
- blocs atelier et preuve

## 6.4 Chantier technique

- nouvelles routes de landing univers
- composants Blade ou structure front equivalents
- nouveaux blocs CMS/settings si necessaire

## 6.5 Criteres de sortie

- la homepage n'est plus catalogue-first
- la navigation expose `Decouvrir`, `Composer`, `Sur mesure`
- l'utilisateur comprend les 3 modes d'achat

## 7. Phase 3 - Pages commerciales coeur

## 7.1 Objectif

Mettre en ligne les pages qui structurent la vente.

## 7.2 Pages prioritaires

- Chambre adulte
- Chambre enfant
- Salon & sejour
- Cuisine & rangement
- Collection Kent ou equivalent
- Collection Lora ou equivalent

## 7.3 Nouvelles typologies de pages

- landing univers
- landing collection
- composition prete
- page realisations
- page guide

## 7.4 Chantiers backend

- logique collections
- logique pages landing si necessaire
- enrichissement SEO

## 7.5 Criteres de sortie

- les univers prioritaires existent
- au moins 2 collections fortes sont en ligne
- au moins 3 compositions pretes sont vendables

## 8. Phase 4 - Builder guide MVP

## 8.1 Objectif

Lancer un premier `Composer` credible sans sur-promesse.

## 8.2 Scope MVP impose

Ne faire qu'un builder de reference au debut:

- `Composer une chambre adulte`

Optionnel en second:

- `Composer une chambre enfant`

## 8.3 Chantier data

- tables `bundles`
- tables `bundle_items`
- `builder_templates`
- `builder_template_steps`
- `builder_template_options`
- `compatibility_rules`
- `builder_sessions`

## 8.4 Chantier produit

- definir 3 a 4 templates de chambre
- definir modules obligatoires et optionnels
- definir collections compatibles
- definir dimensions autorisees
- definir calcul du recap

## 8.5 Chantier front

- page builder
- stepper
- recap sticky
- sorties panier / WhatsApp / estimation

## 8.6 Criteres de sortie

- un client peut composer une chambre sans blocage
- le parcours reste simple
- les combinaisons absurdes sont empechees
- les prix ou estimations sont coherents

## 9. Phase 5 - Sur mesure et lead management

## 9.1 Objectif

Industrialiser la capture et le suivi des demandes complexes.

## 9.2 Pages prioritaires

- Cuisine sur mesure
- Dressing sur mesure
- Aluminium
- Ferronnerie

## 9.3 Chantier data

- `project_request_types`
- `project_requests`
- `project_request_attachments`
- `project_request_events`

## 9.4 Chantier admin

- listing demandes
- detail demande
- changement de statut
- affectation commerciale
- journal d'actions

## 9.5 Chantier front

- formulaire qualifiant
- upload images / plans
- CTA WhatsApp / RDV
- pages realisations associees

## 9.6 Criteres de sortie

- une demande sur mesure est tracable de bout en bout
- l'equipe peut la suivre
- le visiteur n'est pas force dans un faux tunnel panier

## 10. Phase 6 - Optimisation, SEO, analytics

## 10.1 Objectif

Passer du systeme fonctionnel au systeme pilotable et rentable.

## 10.2 Chantiers

- instrumentation analytics
- suivi funnel homepage
- suivi funnel builder
- SEO guides et realisations
- recommandations produits / bundles
- AB tests CTAs

## 10.3 KPI a brancher

- clics hero
- clics vers `Composer`
- clics vers `Sur mesure`
- completion builder
- demandes devis
- conversions WhatsApp
- panier moyen compositions

## 11. Decoupage par streams de travail

## 11.1 Stream produit

- taxonomie
- offre
- bundles
- builder
- sur mesure

## 11.2 Stream UX/UI

- navigation
- homepage
- pages univers
- pages collection
- page builder
- page sur mesure

## 11.3 Stream backend/data

- migrations
- models
- relations
- admin
- seeds et scripts de mapping

## 11.4 Stream contenu/SEO

- copy
- FAQ
- pages guides
- pages realisations
- metas

## 12. Backlog detaille par epic

## Epic A - Taxonomie

Priorite: critique

Stories:

- definir univers finaux
- definir types de meuble finaux
- lister collections existantes
- classifier produits existants
- valider nomenclature

Definition of done:

- mapping complet du catalogue

## Epic B - Data foundation

Priorite: critique

Stories:

- migrations `rooms`
- migrations `product_types`
- migrations `collections`
- enrichissement `products`
- enrichissement `categories`

Definition of done:

- schema deployable sans regression

## Epic C - Homepage & nav

Priorite: haute

Stories:

- nouveau header
- nouveau mega-menu
- nouvelle homepage
- version mobile coherente

Definition of done:

- UX d'entree alignee sur la vision

## Epic D - Univers pages

Priorite: haute

Stories:

- page chambre adulte
- page chambre enfant
- page salon
- page cuisine

Definition of done:

- 4 univers stratégiques en ligne

## Epic E - Collections & bundles

Priorite: haute

Stories:

- modele `bundles`
- 3 bundles chambre
- 2 bundles salon
- 1 bundle salle a manger

Definition of done:

- bundles visibles et vendables

## Epic F - Builder MVP

Priorite: haute mais apres E

Stories:

- template chambre adulte
- etapes du builder
- recap
- conversion

Definition of done:

- parcours composeur utilisable

## Epic G - Sur mesure

Priorite: haute mais apres builder

Stories:

- pages sur mesure
- formulaires qualifiants
- admin suivi demandes

Definition of done:

- pipeline projet actif

## Epic H - Realisations & guides

Priorite: moyenne

Stories:

- page realisations
- detail realisation
- page guide
- linking SEO

Definition of done:

- systeme de preuve et contenu actif

## 13. Sequence recommandee des livraisons

Ordre ferme recommande:

1. taxonomie validee
2. data foundation
3. homepage + nav
4. pages univers
5. collections + bundles
6. builder chambre adulte
7. sur mesure
8. SEO et contenus

## 14. Ce qui peut etre parallellise

Peut avancer en parallele:

- copywriting
- taxonomie detaillee
- inventaire collections
- inventaire photos / realisations

Ne doit pas avancer en parallele sans base:

- builder final
- maquettes haute fidelite finales
- admin complexe bundles

## 15. Criteres de go/no-go par phase

## 15.1 Go phase 2

Seulement si:

- taxonomie validee
- schema data minimal valide

## 15.2 Go phase 4

Seulement si:

- bundles modelises
- collections en place
- compatibilites minimales definies

## 15.3 Go phase 5

Seulement si:

- types de projet sur mesure figes
- process commercial defini

## 16. Risques projet et contremesures

## 16.1 Risque - Le scope explose

Contremesure:

- builder MVP unique
- 4 univers prioritaires maximum au debut

## 16.2 Risque - Catalogue mal mappe

Contremesure:

- scripts de verification
- tableaux de mapping metier

## 16.3 Risque - UI superbe mais impraticable

Contremesure:

- wireframes d'abord
- mobile-first
- copy claire

## 16.4 Risque - Admin insuffisant

Contremesure:

- integrer l'admin dans le scope des phases 1, 4 et 5

## 17. Tableau de priorites resume

| Chantier | Priorite | Pourquoi |
| --- | --- | --- |
| Taxonomie | critique | conditionne tout |
| Data foundation | critique | conditionne le systeme |
| Homepage & nav | haute | impact direct perception et orientation |
| Pages univers | haute | SEO + conversion |
| Bundles | haute | conversion et differenciation |
| Builder MVP | haute | promesse signature |
| Sur mesure | haute | monetisation atelier |
| Realisations & guides | moyenne | preuve et SEO |
| Optimisation analytics | moyenne | pilotage post-lancement |

## 18. Decision recommandee immediate

La prochaine execution concrete devrait etre:

1. produire la taxonomie finalisee produit par produit
2. preparer les migrations Laravel des tables `rooms`, `product_types`, `collections`
3. dessiner la homepage haute fidelite

Si l'ordre est inverse, le chantier perdra en coherence.


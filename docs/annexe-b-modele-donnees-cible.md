# Annexe B - Modele de donnees cible et schema relationnel Maison 216

## 1. Role de cette annexe

Cette annexe transforme la vision produit en structure de donnees exploitable.

Elle sert a:

- concevoir la migration de base de donnees
- preparer le back-office cible
- rendre possible la navigation future
- rendre possible les bundles
- rendre possible le builder guide
- rendre possible les demandes de projet sur mesure

Le principe directeur est simple:

**aucune UX avancee ne doit etre construite sans support data clair.**

## 2. Etat de reference actuel

Le schema actuel contient deja des briques utiles:

- `categories`
- `products`
- `product_images`
- `orders`
- `order_items`
- `settings`
- `users`
- `order_status_history`

Ce schema est propre pour une V1 catalogue.
Il est insuffisant pour:

- les collections
- les bundles
- les templates de composition
- les compatibilites
- les projets sur mesure

## 3. Principes de modelisation

1. separer contenu editorial, catalogue, composition et projet
2. ne pas surcharger `products` avec toute la logique future
3. modeliser les regles de compatibilite explicitement
4. permettre une migration progressive sans casser le site actuel
5. garder les entites commerciales lisibles pour l'admin

## 4. Vue d'ensemble des domaines data

Le schema cible s'organise en 8 domaines:

1. taxonomie catalogue
2. catalogue produit
3. collections et compositions
4. builder guide
5. sur mesure et lead management
6. contenu editorial et SEO
7. commerce et commandes
8. administration et configuration

## 5. Domaine 1 - Taxonomie catalogue

## 5.1 Table `rooms`

Role:

- representer les univers de piece

Exemples:

- chambre_adulte
- chambre_enfant
- salon_sejour
- salle_a_manger
- cuisine_rangement
- bureau
- entree_rangement
- salle_de_bain
- exterieur_jardin

Champs recommandes:

- `id`
- `name`
- `slug`
- `short_label`
- `description`
- `hero_title`
- `hero_subtitle`
- `is_active`
- `position`
- `seo_title`
- `seo_description`
- `created_at`
- `updated_at`

## 5.2 Table `product_types`

Role:

- representer les types de meuble transversaux

Exemples:

- lit
- armoire
- commode
- table_de_nuit
- meuble_tv

Champs recommandes:

- `id`
- `name`
- `slug`
- `description`
- `room_id` nullable
- `is_active`
- `position`
- `seo_title`
- `seo_description`
- `created_at`
- `updated_at`

## 5.3 Evolution de `categories`

La table `categories` reste utile pour:

- les pages SEO
- l'arborescence commerciale
- la compatibilite avec le catalogue actuel

Champs a ajouter:

- `room_id` nullable
- `product_type_id` nullable
- `category_kind` enum
- `landing_intro` text nullable
- `landing_outro` text nullable
- `is_indexable` boolean

Valeurs recommandees pour `category_kind`:

- `universe`
- `subcategory`
- `seo_landing`
- `support`

## 6. Domaine 2 - Catalogue produit

## 6.1 Evolution de `products`

La table `products` reste le coeur transactionnel.

Champs actuels a conserver:

- `category_id`
- `title`
- `slug`
- `price_millimes`
- `compare_at_millimes`
- `stock`
- `sku`
- `brand`
- `main_image`
- `short_description`
- `long_description`
- `attributes`
- `is_active`

Champs a ajouter:

- `room_id` nullable
- `product_type_id` nullable
- `primary_collection_id` nullable
- `sale_mode` enum
- `product_kind` enum
- `is_featured` boolean default false
- `is_customizable` boolean default false
- `is_bundle_eligible` boolean default true
- `lead_time_days_min` integer nullable
- `lead_time_days_max` integer nullable
- `assembly_required` boolean default false
- `material_summary` string nullable
- `dimension_summary` string nullable
- `base_price_millimes` integer nullable
- `quote_only` boolean default false

Valeurs recommandees pour `sale_mode`:

- `standard`
- `configurable`
- `quote_only`

Valeurs recommandees pour `product_kind`:

- `single`
- `module`
- `service_linked`

## 6.2 Table `product_dimensions`

Role:

- stocker dimensions vendables ou references

Champs recommandes:

- `id`
- `product_id`
- `label`
- `width_mm`
- `height_mm`
- `depth_mm`
- `is_default`
- `created_at`
- `updated_at`

## 6.3 Table `materials`

Role:

- normaliser les matieres et supports

Champs recommandes:

- `id`
- `name`
- `slug`
- `description`
- `material_family`
- `position`
- `is_active`

Familles possibles:

- `wood`
- `metal`
- `aluminium`
- `glass`
- `mixed`

## 6.4 Table `finishes`

Role:

- gerer couleurs, effets, textures, finitions commerciales

Champs recommandes:

- `id`
- `name`
- `slug`
- `code`
- `finish_family`
- `swatch_hex` nullable
- `texture_image` nullable
- `is_active`
- `position`

## 6.5 Tables pivots

### `product_material`

- `product_id`
- `material_id`
- `is_primary`

### `product_finish`

- `product_id`
- `finish_id`
- `is_default`
- `price_delta_millimes` nullable

## 7. Domaine 3 - Collections et compositions

## 7.1 Table `collections`

Role:

- regrouper un style, une famille, une narration commerciale

Champs recommandes:

- `id`
- `name`
- `slug`
- `subtitle`
- `description`
- `hero_image`
- `cover_image`
- `room_id` nullable
- `is_active`
- `is_featured`
- `position`
- `seo_title`
- `seo_description`
- `created_at`
- `updated_at`

## 7.2 Table `collection_product`

Role:

- associer produits et collections

Champs recommandes:

- `collection_id`
- `product_id`
- `position`
- `is_highlighted`

## 7.3 Table `bundles`

Role:

- modeliser les compositions pretes

Exemples:

- chambre adulte 4 elements
- salon 3 elements

Champs recommandes:

- `id`
- `name`
- `slug`
- `description`
- `short_pitch`
- `room_id`
- `collection_id` nullable
- `main_image`
- `base_price_millimes`
- `compare_at_millimes` nullable
- `sale_mode`
- `is_active`
- `is_featured`
- `position`
- `seo_title`
- `seo_description`
- `created_at`
- `updated_at`

## 7.4 Table `bundle_items`

Role:

- definir le contenu exact d'un bundle

Champs recommandes:

- `id`
- `bundle_id`
- `product_id`
- `label`
- `quantity`
- `is_required`
- `is_default`
- `can_remove`
- `position`
- `price_delta_millimes` default 0
- `created_at`
- `updated_at`

## 8. Domaine 4 - Builder guide

## 8.1 Table `builder_templates`

Role:

- definir les points d'entree du configurateur guide

Exemples:

- composer_chambre_adulte
- composer_salon
- composer_dressing

Champs recommandes:

- `id`
- `name`
- `slug`
- `room_id`
- `title`
- `subtitle`
- `description`
- `mode` enum
- `is_active`
- `position`
- `cta_label`
- `created_at`
- `updated_at`

Valeurs recommandees pour `mode`:

- `bundle_like`
- `guided_quote`
- `hybrid`

## 8.2 Table `builder_template_steps`

Role:

- decrire les etapes du builder

Champs recommandes:

- `id`
- `builder_template_id`
- `step_key`
- `title`
- `description`
- `step_type`
- `is_required`
- `position`
- `ui_component`
- `created_at`
- `updated_at`

Valeurs possibles pour `step_type`:

- `style_choice`
- `dimension_choice`
- `module_choice`
- `finish_choice`
- `summary`
- `contact_capture`

## 8.3 Table `builder_template_options`

Role:

- representer les choix disponibles par etape

Champs recommandes:

- `id`
- `builder_template_step_id`
- `option_type`
- `label`
- `value`
- `linked_product_id` nullable
- `linked_bundle_id` nullable
- `linked_collection_id` nullable
- `price_delta_millimes` default 0
- `metadata` json nullable
- `position`
- `is_default`
- `created_at`
- `updated_at`

## 8.4 Table `compatibility_rules`

Role:

- exprimer les compatibilites et exclusions

Champs recommandes:

- `id`
- `rule_scope`
- `source_type`
- `source_id`
- `target_type`
- `target_id`
- `rule_type`
- `payload` json nullable
- `is_active`
- `created_at`
- `updated_at`

Valeurs possibles:

- `rule_scope`: product, bundle, template
- `rule_type`: requires, excludes, limits, suggests, dimension_lock

## 8.5 Table `builder_sessions`

Role:

- garder la trace des compositions non finalisees et finalisees

Champs recommandes:

- `id`
- `uuid`
- `builder_template_id`
- `user_id` nullable
- `session_payload` json
- `estimated_total_millimes` nullable
- `status`
- `converted_order_id` nullable
- `converted_project_request_id` nullable
- `created_at`
- `updated_at`

Valeurs possibles pour `status`:

- `started`
- `in_progress`
- `submitted`
- `converted`
- `abandoned`

## 9. Domaine 5 - Sur mesure et lead management

## 9.1 Table `project_request_types`

Role:

- normaliser les demandes sur mesure

Valeurs cibles:

- cuisine_sur_mesure
- dressing_sur_mesure
- bibliotheque_sur_mesure
- meuble_tv_sur_mesure
- placard_sous_pente
- aluminium
- ferronnerie
- verriere
- garde_corps

Champs recommandes:

- `id`
- `name`
- `slug`
- `description`
- `position`
- `is_active`

## 9.2 Table `project_requests`

Role:

- coeur du tunnel de qualification

Champs recommandes:

- `id`
- `project_request_type_id`
- `full_name`
- `phone`
- `email` nullable
- `city`
- `governorate` nullable
- `address` nullable
- `surface_m2` nullable
- `budget_min_millimes` nullable
- `budget_max_millimes` nullable
- `deadline_preference` nullable
- `style_preference` nullable
- `materials_preference` nullable
- `notes` text nullable
- `dimensions_payload` json nullable
- `source_channel` nullable
- `status`
- `assigned_user_id` nullable
- `quoted_total_millimes` nullable
- `appointment_at` nullable
- `created_at`
- `updated_at`

Valeurs recommandees pour `status`:

- `new`
- `qualified`
- `contacted`
- `quoted`
- `won`
- `lost`
- `archived`

## 9.3 Table `project_request_attachments`

Role:

- stocker plans, images, inspirations, captures

Champs recommandes:

- `id`
- `project_request_id`
- `file_path`
- `file_type`
- `title` nullable
- `position`
- `created_at`
- `updated_at`

## 9.4 Table `project_request_events`

Role:

- journaliser le suivi commercial

Champs recommandes:

- `id`
- `project_request_id`
- `user_id` nullable
- `event_type`
- `note` nullable
- `payload` json nullable
- `created_at`

## 10. Domaine 6 - Contenu editorial et SEO

## 10.1 Table `landing_pages`

Role:

- gerer des pages SEO et marketing non strictement categories

Champs recommandes:

- `id`
- `page_type`
- `title`
- `slug`
- `subtitle` nullable
- `intro` text nullable
- `body` longtext nullable
- `hero_image` nullable
- `room_id` nullable
- `collection_id` nullable
- `seo_title`
- `seo_description`
- `is_published`
- `published_at` nullable
- `created_at`
- `updated_at`

## 10.2 Table `realizations`

Role:

- gerer les realisations / chantiers / cas reels

Champs recommandes:

- `id`
- `title`
- `slug`
- `room_id` nullable
- `project_request_type_id` nullable
- `city` nullable
- `summary`
- `description`
- `cover_image`
- `before_image` nullable
- `after_image` nullable
- `is_featured`
- `is_published`
- `published_at` nullable
- `created_at`
- `updated_at`

## 10.3 Table `realization_images`

- `id`
- `realization_id`
- `image_path`
- `caption` nullable
- `position`
- `created_at`
- `updated_at`

## 10.4 Table `guides`

Role:

- publier du contenu inspiration / SEO / conseil

Champs recommandes:

- `id`
- `title`
- `slug`
- `excerpt`
- `body`
- `cover_image` nullable
- `room_id` nullable
- `related_product_type_id` nullable
- `is_published`
- `published_at` nullable
- `seo_title`
- `seo_description`
- `created_at`
- `updated_at`

## 11. Domaine 7 - Commerce et commandes

## 11.1 Tables a conserver telles quelles ou presque

- `orders`
- `order_items`
- `order_status_history`

## 11.2 Evolutions recommandees sur `order_items`

Champs a ajouter:

- `bundle_id` nullable
- `builder_session_id` nullable
- `item_type` enum
- `configuration_payload` json nullable

Valeurs possibles pour `item_type`:

- `product`
- `bundle`
- `configured_set`
- `service_request`

## 12. Domaine 8 - Administration et configuration

## 12.1 Table `settings`

Elle reste utile.
Il faudra simplement l'etendre pour:

- blocks homepage
- messages marketing
- parametres builder
- informations atelier
- informations RDV

## 12.2 Table `users`

Champs futurs possibles:

- `role`
- `department`
- `phone`
- `is_sales`
- `is_project_manager`

## 13. Relations coeur

## 13.1 Relations catalogue

- un `room` a plusieurs `categories`
- un `room` a plusieurs `product_types`
- un `product_type` a plusieurs `products`
- une `category` a plusieurs `products`
- un `product` a plusieurs `product_images`
- un `product` peut appartenir a plusieurs `collections`

## 13.2 Relations compositions

- une `collection` a plusieurs `bundles`
- un `bundle` a plusieurs `bundle_items`
- un `bundle_item` pointe vers un `product`

## 13.3 Relations builder

- un `builder_template` appartient a un `room`
- un `builder_template` a plusieurs `builder_template_steps`
- un `builder_template_step` a plusieurs `builder_template_options`
- les `compatibility_rules` contraignent ces options

## 13.4 Relations sur mesure

- un `project_request` appartient a un `project_request_type`
- un `project_request` a plusieurs `project_request_attachments`
- un `project_request` a plusieurs `project_request_events`

## 14. Strategie de migration incremental

## 14.1 Phase 1 - Ajouter sans casser

Ajouter:

- `rooms`
- `product_types`
- `collections`
- champs additionnels sur `products` et `categories`

Ne rien supprimer.

## 14.2 Phase 2 - Mapper l'existant

Actions:

- mapper categories vers rooms
- mapper produits vers product_types
- identifier collections implicites

## 14.3 Phase 3 - Introduire bundles

Ajouter:

- `bundles`
- `bundle_items`

Puis creer les premieres compositions vendables.

## 14.4 Phase 4 - Introduire builder

Ajouter:

- `builder_templates`
- `builder_template_steps`
- `builder_template_options`
- `compatibility_rules`
- `builder_sessions`

## 14.5 Phase 5 - Introduire sur mesure

Ajouter:

- `project_request_types`
- `project_requests`
- `project_request_attachments`
- `project_request_events`

## 15. Regles metier critiques

## 15.1 Aucun builder sans compatibilites

Il faut pouvoir dire explicitement:

- ce qui est obligatoire
- ce qui est optionnel
- ce qui est exclu
- ce qui est recommande

## 15.2 Aucun projet sur mesure dans le panier standard

Un projet sur mesure doit creer:

- une demande
- un lead
- un suivi

Pas un faux produit e-commerce.

## 15.3 Collections et categories ne sont pas interchangeables

Les categories servent le besoin.
Les collections servent le style.

## 15.4 Un bundle n'est pas une simple categorie

Un bundle doit avoir:

- un nom
- un prix
- un contenu
- des regles de retrait / ajout

## 16. Admin cible a prevoir

Modules admin a concevoir:

- Univers
- Types de meuble
- Collections
- Bundles
- Builder
- Projets sur mesure
- Realisations
- Guides

## 17. Checklist de validation

- [ ] la liste des nouvelles tables est validee
- [ ] les enums metier sont valides
- [ ] les champs ajoutes a `products` sont valides
- [ ] la logique `bundles` est approuvee
- [ ] la logique `builder_templates` est approuvee
- [ ] la logique `project_requests` est approuvee
- [ ] le phasage de migration est approuve

## 18. Decision recommandee immediate

Le prochain chantier technique a lancer apres validation de la taxonomie est:

1. creer `rooms`, `product_types`, `collections`
2. enrichir `products` et `categories`
3. produire les premiers seeders de mapping

C'est le minimum pour sortir proprement du mode "catalogue pur".


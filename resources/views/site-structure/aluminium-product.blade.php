@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $contactUrl = route('contact');
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $contactUrl;

    $aluImage = asset('assets/home/menuiserie-aluminium.jpg');
    $voletImage = asset('assets/home/realizations/volet-roulant-aluminium.webp');
    $pergolaImage = asset('assets/home/realizations/pergola.jpg');
    $restaurantImage = asset('assets/home/realizations/amenagement-restaurant.jpg');
    $villaImage = asset('assets/home/amenagement-sur-mesure.jpg');

    $pages = [
        'guardrail' => [
            'path' => 'aluminium/garde-corps',
            'name' => 'Garde-corps',
            'eyebrow' => 'Menuiserie alu · Garde-corps',
            'h1' => 'Garde-corps aluminium sur mesure en Tunisie.',
            'h1Accent' => 'Sécurité, durabilité et design pour vos balcons et terrasses.',
            'intro' => 'Balcon, terrasse, escalier ou mezzanine : nous fabriquons votre garde-corps aux dimensions exactes de votre espace, dans le style qui complète votre architecture. Aluminium, inox ou mixte, avec ou sans vitrage. Fabrication atelier, pose incluse.',
            'primaryCta' => 'Demander un devis garde-corps',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $pergolaImage,
            'proofs' => ['Fabriqué sur mesure', 'Résistant aux intempéries', 'Design au choix', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Sur mesure au mm', 'label' => 'Balcon, terrasse, escalier ou mezzanine.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Sans entretien lourd', 'label' => 'Aluminium thermolaqué, nettoyage simple.', 'icon' => 'fa-solid fa-sparkles'],
                ['value' => 'Climat tunisien', 'label' => 'Conçu pour extérieur, soleil et air salin.', 'icon' => 'fa-solid fa-sun'],
                ['value' => 'Pose incluse', 'label' => 'Fixations, stabilité et réception sur site.', 'icon' => 'fa-solid fa-screwdriver-wrench'],
            ],
            'contextEyebrow' => 'Pourquoi l’aluminium',
            'contextTitle' => 'Le meilleur matériau pour un garde-corps qui dure sans contrainte.',
            'contextIntro' => 'Un garde-corps doit sécuriser sans alourdir l’architecture. L’aluminium permet un rendu propre, léger, durable et cohérent avec les villas, immeubles et terrasses contemporaines.',
            'benefits' => [
                ['title' => 'Il ne rouille pas', 'copy' => 'Contrairement au fer non traité, l’aluminium thermolaqué résiste à la pluie, au soleil, à l’air salin et aux variations de température.'],
                ['title' => 'Il ne demande pas d’entretien lourd', 'copy' => 'Pas de peinture à refaire tous les deux ans. Un nettoyage simple suffit dans la majorité des cas.'],
                ['title' => 'Il s’adapte à tous les styles', 'copy' => 'Barreaux fins, lames larges, cadre pour verre, teintes RAL et finitions contemporaines ou plus classiques.'],
                ['title' => 'Léger mais solide', 'copy' => 'L’aluminium limite les contraintes sur les fixations et les structures légères comme balcons ou mezzanines.'],
            ],
            'typesEyebrow' => 'Nos types de garde-corps',
            'typesTitle' => 'Un garde-corps pour chaque configuration.',
            'typesIntro' => 'Peu importe la hauteur, la longueur ou la forme de votre espace, nous fabriquons le garde-corps qui s’y adapte exactement.',
            'types' => [
                ['title' => 'Garde-corps de balcon', 'copy' => 'Aluminium plein, à barreaux ou avec verre pour protéger sans bloquer la vue. Fixation sur dallage ou en façade selon configuration.', 'icon' => 'fa-solid fa-grip-lines-vertical'],
                ['title' => 'Garde-corps de terrasse', 'copy' => 'Plus large, plus exposé, il exige matériaux et fixations adaptés à une exposition extérieure prolongée.', 'icon' => 'fa-solid fa-umbrella-beach'],
                ['title' => 'Garde-corps d’escalier', 'copy' => 'S’adapte aux inclinaisons et longueurs, avec main courante aluminium, inox ou bois selon style.', 'icon' => 'fa-solid fa-stairs'],
                ['title' => 'Garde-corps vitré', 'copy' => 'Verre sécurisé pour un rendu moderne et dégagé, idéal pour terrasses avec vue et mezzanines.', 'icon' => 'fa-regular fa-square'],
            ],
            'optionsEyebrow' => 'Remplissages & finitions',
            'optionsTitle' => 'Barreaux, verre ou panneaux pleins : le choix selon votre style.',
            'optionsIntro' => 'Le remplissage détermine le niveau de vue, d’intimité, de sécurité et de style.',
            'options' => [
                ['title' => 'Barreaux verticaux', 'copy' => 'Classique, solide, aéré et économique, avec espacement adapté au rendu souhaité.'],
                ['title' => 'Verre sécurisé', 'copy' => 'Panneaux feuilletés pour un garde-corps presque invisible et une vue dégagée.'],
                ['title' => 'Lames horizontales', 'copy' => 'Effet contemporain et plus d’intimité qu’un modèle à barreaux.'],
                ['title' => 'Finitions RAL', 'copy' => 'Blanc, gris anthracite, noir mat, inox brossé ou teintes coordonnées.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Visite & métré', 'copy' => 'Mesure de l’espace, analyse des fixations et conseil sur design et matériaux.'],
                ['step' => '02', 'title' => 'Devis sous 48h', 'copy' => 'Chiffrage selon longueur, remplissage, fixations et finitions.'],
                ['step' => '03', 'title' => 'Fabrication atelier', 'copy' => 'Fabrication sur cotes exactes dans notre atelier aluminium.'],
                ['step' => '04', 'title' => 'Pose & réception', 'copy' => 'Fixation par notre équipe, vérification de stabilité et garantie atelier.'],
            ],
            'faqTitle' => 'Vos questions sur les garde-corps.',
            'faqs' => [
                ['q' => 'Quel est le prix d’un garde-corps aluminium sur mesure en Tunisie ?', 'a' => 'Le prix dépend de la longueur, du type de remplissage, des fixations et des finitions. Le devis personnalisé reste la seule base fiable.'],
                ['q' => 'Le garde-corps aluminium résiste-t-il au bord de mer ?', 'a' => 'Oui, l’aluminium thermolaqué est adapté aux environnements extérieurs et à l’air salin. Les fixations doivent être choisies selon l’exposition réelle.'],
                ['q' => 'Peut-on poser un garde-corps sur un balcon existant ?', 'a' => 'Dans la plupart des cas oui, par platines ou fixation en façade. La visite technique permet de choisir la solution la plus sûre.'],
                ['q' => 'Le verre d’un garde-corps vitré est-il dangereux ?', 'a' => 'Non si le verre est feuilleté sécurisé : en cas de casse, il reste maintenu par un film intérieur.'],
                ['q' => 'Quelle hauteur prévoir ?', 'a' => 'La hauteur est définie selon l’usage, la réglementation applicable et la configuration. Les projets professionnels peuvent exiger des contraintes spécifiques.'],
                ['q' => 'Travaillez-vous avec les promoteurs ?', 'a' => 'Oui : lots de balcons, escaliers de service, toitures terrasses, livraisons phasées selon chantier.'],
            ],
            'finalTitle' => 'Un projet de garde-corps ?',
            'finalSubtitle' => 'Visite et métré gratuits, devis sous 48h pour une demande complète.',
            'serviceType' => 'Garde-corps aluminium sur mesure',
        ],
        'mosquito' => [
            'path' => 'aluminium/moustiquaire',
            'name' => 'Moustiquaire aluminium',
            'eyebrow' => 'Menuiserie alu · Moustiquaire',
            'h1' => 'Moustiquaire aluminium sur mesure en Tunisie.',
            'h1Accent' => 'Dormez fenêtre ouverte. Sans les moustiques.',
            'intro' => 'De juin à septembre, la chaleur tunisienne oblige à choisir entre fermer les fenêtres et étouffer, ou les ouvrir et se faire dévorer. Nos moustiquaires sur mesure laissent entrer l’air et bloquent les insectes, aux dimensions exactes de vos fenêtres.',
            'primaryCta' => 'Demander un devis moustiquaire',
            'secondaryCta' => 'Voir nos modèles',
            'heroImage' => $aluImage,
            'proofs' => ['Fabriquée sur mesure', 'Pose incluse', 'Résistante au soleil', 'Garantie atelier'],
            'band' => [
                ['value' => 'Sur mesure au mm', 'label' => 'Ajustée à vos fenêtres existantes.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Tous types de fenêtres', 'label' => 'Battantes, coulissantes, portes-fenêtres.', 'icon' => 'fa-regular fa-window-maximize'],
                ['value' => 'Résistante aux UV', 'label' => 'Cadre aluminium et toile adaptée.', 'icon' => 'fa-solid fa-sun'],
                ['value' => 'Pose incluse', 'label' => 'Installation propre, sans travaux lourds.', 'icon' => 'fa-solid fa-screwdriver-wrench'],
            ],
            'contextEyebrow' => 'Le contexte tunisien',
            'contextTitle' => 'En Tunisie, une moustiquaire n’est pas un luxe. C’est une nécessité.',
            'contextIntro' => 'Quand les températures montent, aérer devient indispensable. Une moustiquaire bien posée permet d’ouvrir fenêtres et portes-fenêtres sans insecticide, sans spirales et sans contrainte quotidienne.',
            'benefits' => [
                ['title' => 'L’air frais sans les insectes', 'copy' => 'Vous ouvrez nuit comme jour, sans penser aux moustiques. L’air et la lumière passent, les insectes restent dehors.'],
                ['title' => 'Zéro insecticide', 'copy' => 'Plus besoin de bombes, diffuseurs ou spirales. La protection fonctionne toute la saison.'],
                ['title' => 'Un investissement durable', 'copy' => 'Un cadre aluminium bien posé tient plusieurs saisons et la toile peut être remplacée si nécessaire.'],
            ],
            'typesEyebrow' => 'Nos modèles',
            'typesTitle' => 'Le bon modèle selon votre type de fenêtre.',
            'typesIntro' => 'Chaque fenêtre a sa solution. Nous fabriquons le modèle adapté à votre ouverture, dans vos dimensions exactes.',
            'types' => [
                ['title' => 'Moustiquaire enroulable', 'copy' => 'La toile s’enroule dans un coffre aluminium discret. Le modèle le plus demandé pour fenêtres et portes-fenêtres.', 'icon' => 'fa-solid fa-up-down'],
                ['title' => 'Moustiquaire coulissante', 'copy' => 'Glisse sur rail comme une fenêtre coulissante. Idéale pour baies vitrées et grandes ouvertures.', 'icon' => 'fa-solid fa-arrows-left-right'],
                ['title' => 'Moustiquaire plissée', 'copy' => 'La toile se plisse comme un accordéon et convient aux ouvertures avec peu de profondeur.', 'icon' => 'fa-solid fa-grip-lines'],
                ['title' => 'Moustiquaire fixe', 'copy' => 'Cadre aluminium rigide avec toile tendue, parfait pour fenêtres peu utilisées ou de service.', 'icon' => 'fa-regular fa-square'],
                ['title' => 'Moustiquaire pour porte', 'copy' => 'Adaptée aux portes d’entrée et portes-fenêtres pour laisser circuler l’air sans insectes.', 'icon' => 'fa-solid fa-door-open'],
            ],
            'optionsEyebrow' => 'Ce qui compte',
            'optionsTitle' => 'Pas toutes les moustiquaires ne se valent.',
            'optionsIntro' => 'Le cadre, la toile et la pose font la différence entre une protection durable et un accessoire qui se bloque au premier été.',
            'options' => [
                ['title' => 'Cadre aluminium', 'copy' => 'Ne rouille pas, résiste mieux à la chaleur et garde sa forme dans le temps.'],
                ['title' => 'Toile résistante', 'copy' => 'Toile en fibre de verre ou équivalent, pensée pour les UV et les usages répétés.'],
                ['title' => 'Pose précise', 'copy' => 'Les interstices sont le vrai problème. Une pose aux cotes exactes ferme les passages d’insectes.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Vous nous contactez', 'copy' => 'Vous décrivez vos fenêtres et le modèle qui vous intéresse.'],
                ['step' => '02', 'title' => 'Métré sur place', 'copy' => 'Nous prenons les dimensions exactes de chaque ouverture.'],
                ['step' => '03', 'title' => 'Fabrication sur mesure', 'copy' => 'Fabrication aux cotes de vos fenêtres dans notre atelier.'],
                ['step' => '04', 'title' => 'Pose propre & rapide', 'copy' => 'Installation sans gros travaux et résultat utilisable immédiatement.'],
            ],
            'faqTitle' => 'Vos questions sur les moustiquaires.',
            'faqs' => [
                ['q' => 'Quel est le prix d’une moustiquaire aluminium sur mesure en Tunisie ?', 'a' => 'Le prix dépend du modèle, des dimensions et du nombre d’ouvertures. Le métré permet d’établir un devis fiable.'],
                ['q' => 'Peut-on installer une moustiquaire sur une fenêtre existante ?', 'a' => 'Oui. Elle peut s’adapter à des fenêtres aluminium, PVC ou bois sans modifier lourdement la menuiserie existante.'],
                ['q' => 'La moustiquaire enroulable résiste-t-elle au soleil ?', 'a' => 'Oui si le coffre, la toile et la pose sont adaptés. Pour les ouvertures très exposées au vent, un modèle coulissant ou fixe peut être préférable.'],
                ['q' => 'Combien de temps dure une moustiquaire ?', 'a' => 'Le cadre peut durer longtemps. La toile peut nécessiter un remplacement selon exposition solaire et usage.'],
                ['q' => 'Peut-on équiper une porte d’entrée ?', 'a' => 'Oui, avec des modèles enroulables ou plissés adaptés aux portes et portes-fenêtres.'],
                ['q' => 'Intervenez-vous dans toute la Tunisie ?', 'a' => 'Oui sur les principales villes. Les frais éventuels sont précisés dans le devis.'],
            ],
            'finalTitle' => 'Prêt à dormir fenêtre ouverte ?',
            'finalSubtitle' => 'Métré gratuit sur place, devis sous 48h pour une demande complète.',
            'serviceType' => 'Moustiquaire aluminium sur mesure',
        ],
        'shutter' => [
            'path' => 'aluminium/volet-roulant',
            'name' => 'Volet roulant',
            'eyebrow' => 'Menuiserie alu · Volet roulant',
            'h1' => 'Volet roulant aluminium sur mesure en Tunisie.',
            'h1Accent' => 'Moins de chaleur. Moins de facture. Plus de sécurité.',
            'intro' => 'En Tunisie, un volet roulant bien choisi réduit la chaleur qui entre l’été, protège vos fenêtres la nuit et vous évite de fermer manuellement chaque ouverture. Manuel ou motorisé, fabriqué sur mesure et posé par notre équipe.',
            'primaryCta' => 'Demander un devis volet roulant',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $voletImage,
            'proofs' => ['Fabriqué sur mesure', 'Manuel ou motorisé', 'Réduit la chaleur estivale', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Sur mesure au mm', 'label' => 'Chaque coffre et tablier sont ajustés.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Motorisation disponible', 'label' => 'Télécommande ou commande murale selon modèle.', 'icon' => 'fa-solid fa-bolt'],
                ['value' => 'Climat tunisien', 'label' => 'Protection chaleur, soleil et intimité.', 'icon' => 'fa-solid fa-sun'],
                ['value' => 'Pose incluse', 'label' => 'Réglage, test et mise en service.', 'icon' => 'fa-solid fa-screwdriver-wrench'],
            ],
            'contextEyebrow' => 'Pourquoi c’est essentiel',
            'contextTitle' => 'En Tunisie, un volet roulant n’est pas une décoration. C’est un outil de confort.',
            'contextIntro' => 'L’été tunisien chauffe les façades sud et ouest, augmente la charge de climatisation et expose les pièces aux regards. Le volet roulant ajoute une barrière thermique, visuelle et physique.',
            'benefits' => [
                ['title' => 'Moins chaud l’été', 'copy' => 'Baissé aux heures chaudes, il réduit le rayonnement direct sur les vitres et limite la surchauffe intérieure.'],
                ['title' => 'Sécurité supplémentaire', 'copy' => 'Un volet fermé complique l’accès aux fenêtres et renforce le sentiment de sécurité la nuit.'],
                ['title' => 'Contrôle de la lumière', 'copy' => 'Vous dosez lumière, intimité et ventilation selon l’heure de la journée.'],
            ],
            'typesEyebrow' => 'Manuel ou motorisé',
            'typesTitle' => 'Choisissez selon votre confort et votre budget.',
            'typesIntro' => 'La motorisation devient particulièrement intéressante quand plusieurs ouvertures doivent être fermées chaque jour.',
            'types' => [
                ['title' => 'Volet roulant manuel', 'copy' => 'Actionné par sangle ou manivelle. Simple, robuste et économique pour maisons ou appartements avec peu d’ouvertures.', 'icon' => 'fa-solid fa-hand'],
                ['title' => 'Volet roulant motorisé', 'copy' => 'Moteur intégré, commande par télécommande ou interrupteur. Idéal pour villas, grandes baies et usage quotidien.', 'icon' => 'fa-solid fa-bolt'],
                ['title' => 'Coffre en applique', 'copy' => 'Solution rénovation : le coffre se pose au-dessus de la fenêtre sans gros travaux de maçonnerie.', 'icon' => 'fa-solid fa-box'],
                ['title' => 'Coffre intégré', 'copy' => 'Solution construction neuve : coffre encastré dans le mur pour un rendu plus net.', 'icon' => 'fa-solid fa-border-all'],
            ],
            'optionsEyebrow' => 'Finitions',
            'optionsTitle' => 'La couleur qui s’intègre à votre façade.',
            'optionsIntro' => 'Le volet roulant doit rester cohérent avec les fenêtres et l’architecture extérieure.',
            'options' => [
                ['title' => 'Blanc', 'copy' => 'La teinte la plus demandée, discrète et lumineuse.'],
                ['title' => 'Beige / crème', 'copy' => 'Adaptée aux façades traditionnelles et tons clairs.'],
                ['title' => 'Gris anthracite', 'copy' => 'Le choix contemporain pour maisons modernes.'],
                ['title' => 'Marron / effet bois', 'copy' => 'Pour façades plus classiques ou ambiance chaleureuse.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Visite & conseil', 'copy' => 'Analyse des ouvertures, configuration rénovation ou neuf, choix manuel ou motorisé.'],
                ['step' => '02', 'title' => 'Devis sous 48h', 'copy' => 'Chiffrage ouverture par ouverture avec entraînement et finitions.'],
                ['step' => '03', 'title' => 'Fabrication sur mesure', 'copy' => 'Fabrication aux dimensions exactes de chaque ouverture.'],
                ['step' => '04', 'title' => 'Pose & mise en service', 'copy' => 'Installation, réglages, test de fonctionnement et configuration télécommande si motorisé.'],
            ],
            'faqTitle' => 'Vos questions sur les volets roulants.',
            'faqs' => [
                ['q' => 'Quel est le prix d’un volet roulant aluminium sur mesure en Tunisie ?', 'a' => 'Le prix dépend des dimensions, du type d’entraînement et de la configuration de pose. Le devis après métré est indispensable.'],
                ['q' => 'La motorisation vaut-elle le surcoût ?', 'a' => 'Elle devient très pertinente dès qu’il y a plusieurs ouvertures, pour le confort quotidien et la fermeture centralisée.'],
                ['q' => 'Peut-on installer un volet roulant sans casser les murs ?', 'a' => 'Oui, le coffre en applique est conçu pour la rénovation et se pose sans gros travaux de maçonnerie.'],
                ['q' => 'Un volet roulant réduit-il la chaleur ?', 'a' => 'Oui, surtout sur les façades exposées. Il limite le rayonnement direct sur les vitres pendant les heures chaudes.'],
                ['q' => 'Peut-on motoriser un volet déjà installé ?', 'a' => 'Souvent oui, si le coffre est accessible et compatible. Une visite technique confirme la faisabilité.'],
                ['q' => 'Travaillez-vous avec les promoteurs ?', 'a' => 'Oui : lots de volets roulants pour programmes résidentiels, avec livraisons phasées selon chantier.'],
            ],
            'finalTitle' => 'Un projet de volets roulants ?',
            'finalSubtitle' => 'Visite et métré gratuits, devis sous 48h pour une demande complète.',
            'serviceType' => 'Volet roulant aluminium sur mesure',
        ],
        'sunshade' => [
            'path' => 'aluminium/brise-soleil',
            'name' => 'Brise-soleil',
            'eyebrow' => 'Menuiserie alu · Brise-soleil',
            'h1' => 'Brise-soleil aluminium sur mesure en Tunisie.',
            'h1Accent' => 'Protégez votre maison du soleil. Sans perdre la vue ni la lumière.',
            'intro' => 'Le brise-soleil répond au problème tunisien numéro un : protéger une façade exposée sans fermer complètement les ouvertures ni plonger les pièces dans l’obscurité. Lames fixes ou orientables, résidentiel ou commercial, fabriqué sur mesure et posé par notre équipe.',
            'primaryCta' => 'Demander un devis brise-soleil',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $pergolaImage,
            'proofs' => ['Fabriqué sur mesure', 'Lames fixes ou orientables', 'Réduit la chaleur sans bloquer la vue', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Sur mesure', 'label' => 'Façade, fenêtre, terrasse ou pergola.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Lames fixes ou orientables', 'label' => 'Selon exposition, confort et budget.', 'icon' => 'fa-solid fa-sliders'],
                ['value' => 'Résistant aux UV', 'label' => 'Aluminium thermolaqué pour extérieur.', 'icon' => 'fa-solid fa-sun'],
                ['value' => 'Résidentiel & commercial', 'label' => 'Villas, bureaux, restaurants, façades.', 'icon' => 'fa-solid fa-building'],
            ],
            'contextEyebrow' => 'Pourquoi c’est pertinent',
            'contextTitle' => 'Le soleil tunisien est une force. Le brise-soleil vous permet de la contrôler.',
            'contextIntro' => 'Une façade plein sud ou ouest peut recevoir plusieurs heures de soleil direct par jour. Le brise-soleil bloque le rayonnement direct tout en laissant passer lumière diffuse, vue et ventilation.',
            'benefits' => [
                ['title' => 'Moins chaud sans perdre la lumière', 'copy' => 'Les lames bloquent le soleil direct tout en conservant une pièce lumineuse et agréable.'],
                ['title' => 'Un élément architectural', 'copy' => 'Bien conçu, il transforme une façade simple en signature contemporaine.'],
                ['title' => 'Intimité sans obscurité', 'copy' => 'Il crée un écran discret face au vis-à-vis sans fermer complètement les ouvertures.'],
            ],
            'typesEyebrow' => 'Nos types de brise-soleil',
            'typesTitle' => 'Fixe, orientable ou motorisé : le bon modèle selon votre usage.',
            'typesIntro' => 'Chaque façade, exposition solaire et budget correspond à une configuration différente.',
            'types' => [
                ['title' => 'Lames fixes', 'copy' => 'Angle permanent choisi selon l’orientation. Solution solide, économique et sans mécanisme.'],
                ['title' => 'Lames orientables manuelles', 'copy' => 'Ajustez l’angle selon l’heure et la saison pour équilibrer lumière et protection.'],
                ['title' => 'Lames motorisées', 'copy' => 'Orientation pilotée par commande, selon faisabilité et modèle retenu.'],
                ['title' => 'Brise-soleil de façade', 'copy' => 'Lames filantes sur grandes surfaces pour immeubles, bureaux et commerces.'],
                ['title' => 'Terrasse et pergola', 'copy' => 'Structure de lames au-dessus d’un espace extérieur pour filtrer la lumière.'],
            ],
            'optionsEyebrow' => 'Finitions',
            'optionsTitle' => 'La couleur et le profil qui s’intègrent à votre façade.',
            'optionsIntro' => 'Le brise-soleil est autant une protection qu’un élément architectural visible.',
            'options' => [
                ['title' => 'Lames rectangulaires', 'copy' => 'Classiques, économiques et efficaces.'],
                ['title' => 'Lames design', 'copy' => 'Profils plus fins ou plus travaillés selon le rendu recherché.'],
                ['title' => 'Teintes RAL', 'copy' => 'Mat, satiné ou brillant, coordonnées à la façade.'],
                ['title' => 'Effet bois', 'copy' => 'Sur demande et selon gamme disponible.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Étude & conseil', 'copy' => 'Analyse de l’orientation, exposition solaire, façade et usage.'],
                ['step' => '02', 'title' => 'Plans & devis', 'copy' => 'Conception sur mesure avec modèle, finition et motorisation si retenue.'],
                ['step' => '03', 'title' => 'Fabrication atelier', 'copy' => 'Fabrication des lames et de la structure dans notre atelier aluminium.'],
                ['step' => '04', 'title' => 'Pose & réception', 'copy' => 'Installation, réglage de l’angle et configuration si motorisée.'],
            ],
            'faqTitle' => 'Vos questions sur les brise-soleil.',
            'faqs' => [
                ['q' => 'Quel est le prix d’un brise-soleil aluminium en Tunisie ?', 'a' => 'Le prix dépend du type de lames, des dimensions, de la structure, de la motorisation éventuelle et des finitions. Devis sur visite.'],
                ['q' => 'Quelle différence entre brise-soleil et volet roulant ?', 'a' => 'Le volet roulant ferme l’ouverture. Le brise-soleil filtre le soleil direct tout en conservant lumière, vue et ventilation.'],
                ['q' => 'Réduit-il la consommation de climatisation ?', 'a' => 'Oui, en réduisant le rayonnement direct sur les vitrages exposés. Le gain dépend de l’orientation et de la surface vitrée.'],
                ['q' => 'Peut-on l’installer sur une construction existante ?', 'a' => 'Oui dans beaucoup de cas. La visite technique vérifie la façade, les points d’ancrage et la faisabilité.'],
                ['q' => 'Les lames motorisées sont-elles adaptées au climat tunisien ?', 'a' => 'Oui si la motorisation et la structure sont adaptées à la chaleur, poussière et humidité. La marque et le modèle sont validés au devis.'],
                ['q' => 'Convient-il aux appartements ?', 'a' => 'Oui : fenêtre, balcon, pare-vue ou petite façade. Les villas permettent des solutions plus larges.'],
            ],
            'finalTitle' => 'Un projet de brise-soleil ?',
            'finalSubtitle' => 'Étude et devis gratuits, visite sur place incluse selon zone.',
            'serviceType' => 'Brise-soleil aluminium sur mesure',
        ],
    ];

    $data = $pages[$pageKey];
    $realizations = app(\App\Support\RealizationResolver::class)->forPage($data['path'], 3, 'aluminium');
    $breadcrumbs = [
        ['name' => 'Accueil', 'url' => route('home')],
        ['name' => 'Menuiserie aluminium', 'url' => url('/aluminium')],
        ['name' => $data['name'], 'url' => url('/' . $data['path'])],
    ];

    $allLinks = collect([
        ['title' => 'Fenêtre aluminium', 'href' => url('/aluminium/fenetre-aluminium'), 'copy' => 'RPT, double vitrage, sur mesure.'],
        ['title' => 'Porte aluminium', 'href' => url('/aluminium/porte-aluminium'), 'copy' => 'Entrée, porte-fenêtre, baie.'],
        ['title' => 'Garde-corps aluminium', 'href' => url('/aluminium/garde-corps'), 'copy' => 'Balcon, terrasse, escalier.'],
        ['title' => 'Volet roulant', 'href' => url('/aluminium/volet-roulant'), 'copy' => 'Manuel ou motorisé.'],
        ['title' => 'Moustiquaire aluminium', 'href' => url('/aluminium/moustiquaire'), 'copy' => 'Enroulable, coulissante, fixe.'],
        ['title' => 'Brise-soleil', 'href' => url('/aluminium/brise-soleil'), 'copy' => 'Lames fixes ou orientables.'],
        ['title' => 'Menuiserie aluminium', 'href' => url('/aluminium'), 'copy' => 'Retour au hub aluminium.'],
    ])->reject(fn ($link) => $link['href'] === url('/' . $data['path']))->values();
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Menuiserie aluminium', 'item' => url('/aluminium')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $data['name'], 'item' => url('/' . $data['path'])],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'Service',
    'serviceType' => $data['serviceType'],
    'name' => $data['h1'],
    'provider' => [
        '@type' => 'LocalBusiness',
        'name' => 'Maison 216',
        'url' => url('/'),
    ],
    'areaServed' => [
        '@type' => 'Country',
        'name' => 'Tunisie',
    ],
    'description' => $data['intro'],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($data['faqs'])->map(fn ($faq) => [
        '@type' => 'Question',
        'name' => $faq['q'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $faq['a'],
        ],
    ])->values()->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
<section class="border-b border-[#eadfce] bg-[#fbf7ee]">
    <div class="container mx-auto px-4 py-4">
        <nav class="flex flex-wrap items-center gap-2 text-sm font-semibold text-[#6a5a4c]" aria-label="Fil d'Ariane">
            @foreach($breadcrumbs as $crumb)
                @if(!$loop->first)
                    <i class="fa-solid fa-angle-right text-[10px] text-[#b88a3b]"></i>
                @endif
                @if(!$loop->last)
                    <a href="{{ $crumb['url'] }}" class="transition hover:text-[#171411]">{{ $crumb['name'] }}</a>
                @else
                    <span class="text-[#171411]">{{ $crumb['name'] }}</span>
                @endif
            @endforeach
        </nav>
    </div>
</section>

<section class="relative overflow-hidden border-b border-[#eadfce] bg-[#fbf7ee]">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_18%,rgba(184,138,59,0.15),transparent_34%),radial-gradient(circle_at_86%_18%,rgba(40,62,62,0.12),transparent_30%)]"></div>
    <div class="container relative mx-auto grid gap-10 px-4 py-14 lg:grid-cols-[0.9fr_1.1fr] lg:items-center lg:py-20">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-[#d8c7af] bg-white/72 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#8b6426]">
                <i class="fa-solid fa-border-all"></i>
                {{ $data['eyebrow'] }}
            </div>

            <h1 class="font-display mt-7 max-w-4xl text-4xl font-extrabold leading-[1.02] tracking-[-0.04em] text-[#171411] sm:text-5xl lg:text-6xl">
                {{ $data['h1'] }}
                <span class="block text-[#a47834]">{{ $data['h1Accent'] }}</span>
            </h1>

            <p class="mt-6 max-w-3xl text-base leading-8 text-[#55473c] sm:text-lg">{{ $data['intro'] }}</p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white shadow-[0_20px_45px_rgba(23,20,17,0.16)] transition hover:bg-[#a47834]">
                    <i class="fa-regular fa-clipboard"></i>
                    {{ $data['primaryCta'] }}
                </a>
                <a href="#realisations-aluminium" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white/78 px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834] hover:bg-white">
                    <i class="fa-regular fa-images"></i>
                    {{ $data['secondaryCta'] }}
                </a>
            </div>

            <div class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($data['proofs'] as $proof)
                    <span class="inline-flex items-center gap-2 text-sm font-bold text-[#4f4236]">
                        <i class="fa-solid fa-check text-[#a47834]"></i>
                        {{ $proof }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="relative">
            <div class="rounded-[40px] border border-[#d8c7af] bg-white p-3 shadow-[0_36px_90px_rgba(23,20,17,0.16)]">
                <div class="relative min-h-[360px] overflow-hidden rounded-[30px] bg-cover bg-center lg:min-h-[540px]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.02), rgba(23,20,17,0.58)), url('{{ $data['heroImage'] }}');">
                    <div class="absolute bottom-6 left-6 right-6 rounded-[26px] border border-white/18 bg-[#171411]/72 p-5 text-white backdrop-blur">
                        <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Fabrication aluminium</div>
                        <p class="mt-2 text-sm leading-6 text-white/78">Métré, fabrication sur cotes, finition, pose et réglages dans un parcours suivi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="border-b border-[#eadfce] bg-white">
    <div class="container mx-auto grid gap-0 px-4 py-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($data['band'] as $item)
            <div class="border-[#eadfce] py-5 lg:border-r lg:px-6 lg:last:border-r-0">
                <div class="flex items-start gap-4">
                    <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#f4ead8] text-[#a47834]">
                        <i class="{{ $item['icon'] }}"></i>
                    </span>
                    <div>
                        <div class="font-display text-xl font-extrabold text-[#171411]">{{ $item['value'] }}</div>
                        <div class="mt-1 text-sm leading-6 text-[#66584d]">{{ $item['label'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-4xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">{{ $data['contextEyebrow'] }}</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $data['contextTitle'] }}</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">{{ $data['contextIntro'] }}</p>
        </div>

        <div @class([
            'grid gap-5 md:grid-cols-2',
            'xl:grid-cols-3' => count($data['benefits']) === 3,
            'xl:grid-cols-4' => count($data['benefits']) !== 3,
        ])>
            @foreach($data['benefits'] as $benefit)
                <article class="rounded-[30px] border border-[#eadfce] bg-white p-6">
                    <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $benefit['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $benefit['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-4xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">{{ $data['typesEyebrow'] }}</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $data['typesTitle'] }}</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">{{ $data['typesIntro'] }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($data['types'] as $type)
                <article class="rounded-[30px] border border-[#eadfce] bg-[#fbf7ee] p-6">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#171411] text-[#d5b170]">
                        <i class="{{ $type['icon'] ?? 'fa-solid fa-border-all' }}"></i>
                    </span>
                    <h3 class="font-display mt-6 text-xl font-extrabold text-[#171411]">{{ $type['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $type['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-4xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">{{ $data['optionsEyebrow'] }}</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $data['optionsTitle'] }}</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">{{ $data['optionsIntro'] }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach($data['options'] as $option)
                <article class="rounded-[30px] border border-[#eadfce] bg-white p-6">
                    <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $option['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $option['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

@if($realizations->isNotEmpty())
<section id="realisations-aluminium" class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Réalisations aluminium</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold sm:text-4xl">Quelques réalisations liées à cette gamme.</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            @foreach($realizations as $realization)
                <a href="{{ $realization['url'] }}" class="group relative min-h-[320px] overflow-hidden rounded-[34px] bg-cover bg-center p-6 transition hover:-translate-y-1" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.82)), url('{{ $realization['image'] }}');">
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <span class="inline-flex w-max rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-bold text-[#e7c98d] backdrop-blur">{{ $realization['place'] }}</span>
                        <div>
                            <h3 class="font-display text-2xl font-extrabold">{{ $realization['title'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-white/76">{{ $realization['copy'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Le processus</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Du métré à la pose, en 4 étapes.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-4">
            @foreach($data['process'] as $step)
                <article class="rounded-[30px] border border-[#eadfce] bg-[#fbf7ee] p-6">
                    <div class="font-display text-5xl font-extrabold text-[#a47834]/20">{{ $step['step'] }}</div>
                    <h3 class="font-display mt-5 text-xl font-extrabold text-[#171411]">{{ $step['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $step['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Questions fréquentes</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $data['faqTitle'] }}</h2>
        </div>

        <div class="mx-auto max-w-4xl divide-y divide-[#eadfce] rounded-[34px] border border-[#eadfce] bg-white p-2">
            @foreach($data['faqs'] as $faq)
                <details class="group rounded-[26px] px-5 py-4 open:bg-[#fbf7ee]" @if($loop->first) open @endif>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-lg font-extrabold text-[#171411]">
                        {{ $faq['q'] }}
                        <i class="fa-solid fa-chevron-down shrink-0 text-sm text-[#a47834] transition group-open:rotate-180"></i>
                    </summary>
                    <p class="mt-4 max-w-3xl text-base leading-8 text-[#5f5146]">{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="font-display text-3xl font-extrabold sm:text-5xl">{{ $data['finalTitle'] }}</h2>
        <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-white/72">{{ $data['finalSubtitle'] }}</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#d5b170] px-7 py-4 text-sm font-extrabold text-[#171411]">
                <i class="fa-regular fa-clipboard"></i>
                {{ $data['primaryCta'] }}
            </a>
            <a href="{{ $whatsappUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/15 px-7 py-4 text-sm font-extrabold text-white">
                <i class="fa-brands fa-whatsapp"></i>
                WhatsApp atelier alu
            </a>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-14 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="mb-7 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Explorer la menuiserie aluminium</div>
            <h3 class="font-display mt-3 text-2xl font-extrabold text-[#171411] sm:text-3xl">Nos autres produits aluminium.</h3>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
            @foreach($allLinks as $link)
                <a href="{{ $link['href'] }}" class="group rounded-[26px] border border-[#eadfce] bg-white p-5 transition hover:-translate-y-1 hover:border-[#c7a36a] hover:shadow-[0_18px_45px_rgba(23,20,17,0.08)]">
                    <h4 class="font-display text-lg font-extrabold text-[#171411]">{{ $link['title'] }}</h4>
                    <p class="mt-3 text-sm leading-6 text-[#5f5146]">{{ $link['copy'] }}</p>
                    <div class="mt-5 text-sm font-extrabold text-[#8e6322]">Voir la page <i class="fa-solid fa-arrow-right ml-1 text-xs transition group-hover:translate-x-1"></i></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection

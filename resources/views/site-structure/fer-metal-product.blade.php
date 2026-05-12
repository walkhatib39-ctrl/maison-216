@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $contactUrl = route('contact');
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $contactUrl;

    $metalImage = asset('assets/home/fabrication-metallique.jpg');
    $portailImage = asset('assets/home/realizations/portail-metal.jpg');
    $pergolaImage = asset('assets/home/realizations/pergola.jpg');
    $restaurantImage = asset('assets/home/realizations/amenagement-restaurant.jpg');
    $surMesureImage = asset('assets/home/amenagement-sur-mesure.jpg');
    $boisImage = asset('assets/home/menuiserie-bois.webp');

    $pages = [
        'gate' => [
            'path' => 'fer-metal/portail-fer-forge',
            'name' => 'Portail fer forgé',
            'eyebrow' => 'Fabrication métallique · Portail',
            'h1' => 'Portail fer forgé sur mesure en Tunisie.',
            'h1Accent' => 'La première impression de votre maison. Faite pour durer.',
            'intro' => 'Votre portail est le premier élément que voit quiconque s’approche de votre maison. Battant ou coulissant, fer forgé classique ou métal contemporain, manuel ou motorisé : nous le fabriquons sur mesure dans notre atelier, avec un traitement anti-corrosion sérieux et une pose suivie par notre équipe.',
            'primaryCta' => 'Demander un devis portail',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $portailImage,
            'proofs' => ['Fabriqué sur mesure', 'Traitement anti-corrosion', 'Manuel ou motorisé', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Sur mesure', 'label' => 'Dimensions, style, terrain et ouverture.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Anti-rouille inclus', 'label' => 'Préparation, primaire et finition adaptée.', 'icon' => 'fa-solid fa-shield-halved'],
                ['value' => 'Motorisation possible', 'label' => 'Selon poids, usage et configuration.', 'icon' => 'fa-solid fa-bolt'],
                ['value' => 'Pose incluse', 'label' => 'Scellement, réglage et tests sur site.', 'icon' => 'fa-solid fa-screwdriver-wrench'],
            ],
            'contextEyebrow' => 'Les styles',
            'contextTitle' => 'Classique, contemporain ou mixte : le portail qui correspond à votre maison.',
            'contextIntro' => 'Le portail n’est pas seulement une fermeture. C’est une signature visible depuis la rue, un élément de sécurité et une décision architecturale qui doit s’accorder à la façade, au portillon et à la clôture.',
            'benefits' => [
                ['title' => 'Fer forgé classique', 'copy' => 'Volutes, arabesques, motifs géométriques ou floraux. Idéal pour maisons traditionnelles et villas méditerranéennes.'],
                ['title' => 'Contemporain pleine tôle', 'copy' => 'Lignes épurées, intimité renforcée, couleurs sobres comme noir mat ou gris anthracite.'],
                ['title' => 'Semi-ajouré', 'copy' => 'Bas plein pour l’intimité, haut ajouré pour alléger visuellement. Le compromis le plus polyvalent.'],
                ['title' => 'Avec soubassement', 'copy' => 'Partie métallique coordonnée avec un soubassement maçonné ou pierre pour ancrer visuellement l’entrée.'],
            ],
            'typesEyebrow' => 'Battant ou coulissant',
            'typesTitle' => 'Le choix dépend de votre terrain, pas seulement de votre goût.',
            'typesIntro' => 'Nous analysons le recul, la pente, la voie publique, le type de sol et la motorisation souhaitée avant de recommander l’ouverture.',
            'types' => [
                ['title' => 'Portail battant', 'copy' => 'Deux vantaux qui s’ouvrent vers l’intérieur ou l’extérieur. Plus élégant, plus simple, souvent plus économique quand l’allée a assez de recul.', 'icon' => 'fa-solid fa-door-open'],
                ['title' => 'Portail coulissant', 'copy' => 'Un vantail qui glisse latéralement. Indispensable sur terrain en pente, allée courte ou besoin de motorisation confortable.', 'icon' => 'fa-solid fa-arrows-left-right'],
                ['title' => 'Portail motorisé', 'copy' => 'Moteur adapté au poids, télécommande, sécurité anti-écrasement et déblocage manuel en cas de coupure selon modèle.', 'icon' => 'fa-solid fa-bolt'],
            ],
            'detailEyebrow' => 'La durabilité',
            'detailTitle' => 'Pourquoi certains portails rouillent vite et d’autres tiennent longtemps.',
            'detailIntro' => 'Le problème n’est pas le fer. Le problème est un traitement bâclé : acier mal préparé, peinture liquide légère, aucune protection sérieuse sur les soudures. Notre approche vise une finition durable et vérifiable.',
            'details' => [
                ['title' => 'Décapage', 'copy' => 'Traces d’oxydation, graisse et impuretés sont retirées avant toute application de protection.'],
                ['title' => 'Primaire anti-corrosion', 'copy' => 'Une couche de protection est appliquée sur l’acier préparé pour limiter l’humidité et l’oxydation.'],
                ['title' => 'Thermolaquage four', 'copy' => 'Finition en poudre cuite, plus régulière et plus résistante qu’une simple peinture appliquée à froid.'],
                ['title' => 'Finitions RAL', 'copy' => 'Noir mat, anthracite, crème, marron, vert forêt, effet martelé ou bicoloration selon style.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Visite & conseil', 'copy' => 'Évaluation de l’ouverture, du terrain, du recul, de la pente et du type d’ouverture adapté.'],
                ['step' => '02', 'title' => 'Devis sous 48h', 'copy' => 'Chiffrage selon dimensions, design, finition et motorisation éventuelle.'],
                ['step' => '03', 'title' => 'Fabrication atelier', 'copy' => 'Fabrication métal, traitement anti-corrosion, thermolaquage et contrôle avant pose.'],
                ['step' => '04', 'title' => 'Pose & mise en service', 'copy' => 'Scellement, rail ou pivots, raccordement si motorisé, tests et réglages.'],
            ],
            'faqTitle' => 'Vos questions sur les portails.',
            'faqs' => [
                ['q' => 'Quel est le prix d’un portail fer forgé sur mesure en Tunisie ?', 'a' => 'Le prix dépend des dimensions, du style, du type d’ouverture, de la motorisation, du traitement et de la pose. Nous évitons les prix génériques : le devis sur visite est la seule base fiable.'],
                ['q' => 'Battant ou coulissant : comment choisir ?', 'a' => 'Le battant convient si l’allée a assez de recul et si le terrain est plat. Le coulissant est préférable sur terrain en pente, allée courte ou portail lourd à motoriser.'],
                ['q' => 'La motorisation est-elle fiable avec les coupures de courant ?', 'a' => 'Les motorisations sérieuses prévoient un déblocage manuel. Certains modèles peuvent intégrer une batterie de secours selon budget et usage.'],
                ['q' => 'Peut-on motoriser un portail existant ?', 'a' => 'Oui si la structure est saine, bien équilibrée et compatible avec le moteur. Une visite technique confirme le poids, les fixations et le guidage.'],
                ['q' => 'Combien de temps prend la fabrication et la pose ?', 'a' => 'Le délai dépend du design, de la finition et de la motorisation. Il est annoncé dans le devis après validation technique.'],
                ['q' => 'Votre portail résiste-t-il au bord de mer ?', 'a' => 'Oui avec un traitement adapté. En bord de mer, nous recommandons une protection renforcée contre l’air salin selon exposition.'],
                ['q' => 'Faites-vous aussi le portillon piéton ?', 'a' => 'Oui. Le portillon peut être fabriqué avec le même style, la même couleur et la même finition que le portail principal.'],
                ['q' => 'Travaillez-vous avec les promoteurs ?', 'a' => 'Oui : portails, clôtures, garde-corps et ouvrages métalliques pour programmes résidentiels, avec phasage chantier.'],
            ],
            'finalTitle' => 'Un projet de portail ?',
            'finalSubtitle' => 'Visite technique gratuite, devis sous 48h pour une demande complète, délai annoncé au devis.',
            'serviceType' => 'Portail fer forgé sur mesure',
        ],
        'pergola' => [
            'path' => 'fer-metal/pergola-metallique',
            'name' => 'Pergola métallique',
            'eyebrow' => 'Fabrication métallique · Pergola',
            'h1' => 'Pergola métallique sur mesure en Tunisie.',
            'h1Accent' => 'Transformez votre terrasse en espace de vie toute l’année.',
            'intro' => 'En Tunisie, une terrasse sans couverture devient vite inutilisable en été et inconfortable quand il pleut ou qu’il vente. Une pergola bien conçue crée un espace extérieur protégé, utilisable plus souvent, pour votre maison, votre villa ou votre établissement.',
            'primaryCta' => 'Demander un devis pergola',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $pergolaImage,
            'proofs' => ['Structure sur mesure', 'Anti-corrosion inclus', 'Résidentiel & commercial', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Sur mesure', 'label' => 'Adossée, autoportée ou terrasse CHR.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Vent & UV', 'label' => 'Structure et finition adaptées à l’extérieur.', 'icon' => 'fa-solid fa-wind'],
                ['value' => 'Maison & CHR', 'label' => 'Villa, restaurant, café, hôtel.', 'icon' => 'fa-solid fa-utensils'],
                ['value' => 'Pose incluse', 'label' => 'Ancrages, couverture et réception.', 'icon' => 'fa-solid fa-screwdriver-wrench'],
            ],
            'contextEyebrow' => 'Pourquoi c’est pertinent',
            'contextTitle' => 'Une terrasse couverte, c’est une pièce en plus.',
            'contextIntro' => 'Une terrasse non protégée finit souvent sous-utilisée. La pergola transforme cet espace en salon extérieur, coin repas, zone d’attente ou surface commerciale exploitable.',
            'benefits' => [
                ['title' => 'Utilisable plus souvent', 'copy' => 'Protection contre le soleil direct, la pluie et le vent selon couverture et options retenues.'],
                ['title' => 'Valeur immobilière', 'copy' => 'Une terrasse couverte augmente la valeur d’usage perçue d’une villa ou maison.'],
                ['title' => 'Couverts en plus pour les pros', 'copy' => 'Pour cafés et restaurants, chaque mètre carré couvert peut devenir une surface d’exploitation rentable.'],
            ],
            'typesEyebrow' => 'Nos types de pergolas',
            'typesTitle' => 'Adossée, autoportée ou bioclimatique : le bon modèle selon votre espace.',
            'typesIntro' => 'Le choix dépend de la façade, du terrain, de l’exposition, du budget et du niveau de confort attendu.',
            'types' => [
                ['title' => 'Pergola adossée', 'copy' => 'Fixée au mur d’un côté et portée par des poteaux de l’autre. La plus courante pour terrasses le long d’une façade.', 'icon' => 'fa-solid fa-house-chimney-window'],
                ['title' => 'Pergola autoportée', 'copy' => 'Structure indépendante sur ses poteaux. Idéale pour jardin, piscine, terrasse isolée ou espace restaurant ouvert.', 'icon' => 'fa-solid fa-warehouse'],
                ['title' => 'Couverture fixe', 'copy' => 'Polycarbonate, tôle ou bois selon priorité : budget, pluie, ombre, lumière ou rendu esthétique.', 'icon' => 'fa-solid fa-layer-group'],
                ['title' => 'Lames orientables', 'copy' => 'Solution plus confortable et premium, manuelle ou motorisée selon faisabilité et budget.', 'icon' => 'fa-solid fa-sliders'],
                ['title' => 'Stores latéraux', 'copy' => 'Protection contre vent, pluie latérale ou vis-à-vis, selon compatibilité de la structure.', 'icon' => 'fa-solid fa-arrows-left-right'],
            ],
            'detailEyebrow' => 'Les couvertures',
            'detailTitle' => 'Polycarbonate, bois, tôle ou lames : la couverture selon votre priorité.',
            'detailIntro' => 'La couverture décide du confort, du niveau d’ombre, de la protection pluie et de l’ambiance. Nous orientons selon usage résidentiel ou professionnel.',
            'details' => [
                ['title' => 'Polycarbonate', 'copy' => 'Léger, économique, protège de la pluie et filtre la lumière selon teinte choisie.'],
                ['title' => 'Bois traité', 'copy' => 'Ambiance chaleureuse et ombre agréable. Association métal + bois possible grâce à l’atelier intégré.'],
                ['title' => 'Tôle ou bac acier', 'copy' => 'Protection forte contre la pluie, adaptée aux espaces utilitaires ou budgets maîtrisés.'],
                ['title' => 'Lames orientables aluminium', 'copy' => 'Confort premium pour moduler ombre, lumière et ventilation selon le moment de la journée.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Visite & étude', 'copy' => 'Analyse de l’espace, exposition solaire, terrain, ancrages et type de couverture.'],
                ['step' => '02', 'title' => 'Plans & devis', 'copy' => 'Conception selon dimensions, structure, couverture et options. Devis détaillé sous 48h si dossier complet.'],
                ['step' => '03', 'title' => 'Fabrication atelier', 'copy' => 'Structure métallique, traitement anti-corrosion, thermolaquage et préparation des éléments.'],
                ['step' => '04', 'title' => 'Pose & réception', 'copy' => 'Scellement, pose de la couverture, raccordements éventuels et réception chantier.'],
            ],
            'faqTitle' => 'Vos questions sur les pergolas.',
            'faqs' => [
                ['q' => 'Quel est le prix d’une pergola sur mesure en Tunisie ?', 'a' => 'Le prix dépend du type, des dimensions, de la couverture, de la finition et des options. Une pergola adossée simple n’a pas le même budget qu’une bioclimatique motorisée.'],
                ['q' => 'Faut-il un permis de construire pour une pergola ?', 'a' => 'Selon surface, commune et configuration, une déclaration ou autorisation peut être nécessaire. Nous recommandons de vérifier auprès de la municipalité avant lancement.'],
                ['q' => 'Quelle différence entre adossée et autoportée ?', 'a' => 'L’adossée s’appuie sur la façade et coûte souvent moins cher. L’autoportée est indépendante et peut être placée librement dans un jardin ou une terrasse.'],
                ['q' => 'La structure résiste-t-elle au climat tunisien ?', 'a' => 'Oui si la conception, les ancrages et le traitement de surface sont adaptés à l’exposition au soleil, au vent et à l’humidité.'],
                ['q' => 'Peut-on ajouter des stores latéraux ?', 'a' => 'Oui selon structure, dimensions et système choisi. La faisabilité se valide en visite technique.'],
                ['q' => 'La pergola bioclimatique est-elle utile en Tunisie ?', 'a' => 'Oui pour contrôler ombre, lumière et ventilation durant les longues périodes chaudes. La faisabilité dépend de la structure et du budget.'],
                ['q' => 'Quel délai pour fabriquer et poser une pergola ?', 'a' => 'Le délai dépend de la complexité, du volume, de la finition et des options. Il est annoncé dans le devis.'],
                ['q' => 'Pouvez-vous faire un habillage bois ?', 'a' => 'Oui selon projet. L’intérêt de Maison216 est de pouvoir coordonner structure métallique et éléments bois dans un seul parcours.'],
            ],
            'finalTitle' => 'Un projet de pergola ?',
            'finalSubtitle' => 'Visite et étude gratuites, devis sous 48h pour une demande complète.',
            'serviceType' => 'Pergola métallique sur mesure',
        ],
        'guardrail' => [
            'path' => 'fer-metal/garde-corps',
            'name' => 'Garde-corps métallique',
            'eyebrow' => 'Fabrication métallique · Garde-corps',
            'h1' => 'Garde-corps métallique sur mesure en Tunisie.',
            'h1Accent' => 'Sécurité, style et durabilité pour vos balcons, escaliers et terrasses.',
            'intro' => 'Balcon, escalier intérieur, mezzanine ou terrasse : nous fabriquons votre garde-corps en acier ou en fer forgé, aux dimensions exactes de votre espace, dans le style qui complète votre architecture. Fabrication atelier, traitement anti-corrosion et pose par notre équipe.',
            'primaryCta' => 'Demander un devis garde-corps',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $surMesureImage,
            'proofs' => ['Fabriqué sur mesure', 'Anti-corrosion traité', 'Sécurité cadrée', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Sur mesure au ml', 'label' => 'Balcon, terrasse, escalier, mezzanine.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Acier · inox · fer forgé', 'label' => 'Matériau choisi selon usage et style.', 'icon' => 'fa-solid fa-grip-lines-vertical'],
                ['value' => 'Intérieur & extérieur', 'label' => 'Finition adaptée à l’exposition.', 'icon' => 'fa-solid fa-cloud-sun'],
                ['value' => 'Pose incluse', 'label' => 'Fixations, stabilité et réception.', 'icon' => 'fa-solid fa-screwdriver-wrench'],
            ],
            'contextEyebrow' => 'Où en avez-vous besoin',
            'contextTitle' => 'Partout où une hauteur représente un danger. Partout où l’espace mérite une belle finition.',
            'contextIntro' => 'Un garde-corps bien conçu transforme un escalier ordinaire en élément architectural, un balcon fonctionnel en espace avec du caractère et une mezzanine en zone visuellement légère mais sécurisée.',
            'benefits' => [
                ['title' => 'Balcon & terrasse', 'copy' => 'Le cas le plus courant : protection extérieure avec traitement de surface sérieux.'],
                ['title' => 'Escalier intérieur', 'copy' => 'Rampe visible depuis l’entrée ou le salon, à traiter comme un élément décoratif fort.'],
                ['title' => 'Mezzanine & duplex', 'copy' => 'Sécuriser sans fermer l’espace : barreaux fins, verre sécurisé ou acier contemporain.'],
                ['title' => 'Espace professionnel', 'copy' => 'Restaurant, hôtel, boutique ou bureau : solidité, durabilité et cohérence avec l’identité du lieu.'],
            ],
            'typesEyebrow' => 'Les styles',
            'typesTitle' => 'Du fer forgé classique à l’acier contemporain épuré.',
            'typesIntro' => 'Deux grandes familles coexistent en Tunisie : l’ornement classique et la ligne contemporaine. Nous orientons selon architecture et usage.',
            'types' => [
                ['title' => 'Fer forgé classique', 'copy' => 'Volutes, arabesques, motifs floraux ou géométriques pour villas méditerranéennes et maisons traditionnelles.', 'icon' => 'fa-solid fa-pen-nib'],
                ['title' => 'Acier contemporain', 'copy' => 'Barreaux droits, lignes nettes, noir mat ou anthracite. Le style dominant des nouvelles constructions.', 'icon' => 'fa-solid fa-grip-lines-vertical'],
                ['title' => 'Acier & verre sécurisé', 'copy' => 'Cadre acier et panneaux feuilletés pour sécuriser sans bloquer la lumière ni la vue.', 'icon' => 'fa-regular fa-square'],
                ['title' => 'Inox brossé', 'copy' => 'Aspect haut de gamme et résistance forte, surtout pour intérieurs humides ou projets bord de mer.'],
                ['title' => 'Lames horizontales', 'copy' => 'Rendu contemporain et plus massif, très utilisé sur villas modernes et espaces professionnels.'],
            ],
            'detailEyebrow' => 'Durabilité & sécurité',
            'detailTitle' => 'Un garde-corps doit être beau, mais il doit surtout tenir.',
            'detailIntro' => 'La durabilité dépend du traitement. La sécurité dépend des dimensions, espacements, fixations et supports. Les deux doivent être pensés dès la visite technique.',
            'details' => [
                ['title' => 'Décapage & dégraissage', 'copy' => 'Les impuretés et traces d’oxydation sont retirées avant protection.'],
                ['title' => 'Primaire anti-corrosion', 'copy' => 'Couche de protection avant finition, surtout pour extérieur et zones exposées.'],
                ['title' => 'Hauteur & espacement', 'copy' => 'Les dimensions sont cadrées selon usage résidentiel ou professionnel et contraintes de sécurité.'],
                ['title' => 'Fixations calculées', 'copy' => 'Support béton, métal ou bois : la fixation doit être adaptée au lieu et à la charge.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Visite & métré', 'copy' => 'Mesure de l’espace, évaluation du support et conseil sur style, matériau et remplissage.'],
                ['step' => '02', 'title' => 'Devis sous 48h', 'copy' => 'Chiffrage au mètre linéaire selon design, matériau, finition et fixation.'],
                ['step' => '03', 'title' => 'Fabrication atelier', 'copy' => 'Fabrication aux dimensions exactes, traitement de surface et finition.'],
                ['step' => '04', 'title' => 'Pose & réception', 'copy' => 'Fixation par notre équipe, contrôle de stabilité et garantie atelier.'],
            ],
            'faqTitle' => 'Vos questions sur les garde-corps.',
            'faqs' => [
                ['q' => 'Quel est le prix d’un garde-corps métallique sur mesure en Tunisie ?', 'a' => 'Le prix dépend du style, de la longueur, du remplissage, des finitions et des fixations. Le devis au mètre linéaire est établi après métré.'],
                ['q' => 'Quelle différence entre garde-corps métallique et aluminium ?', 'a' => 'Le métal offre plus de robustesse et de possibilités stylistiques, notamment fer forgé et acier contemporain. L’aluminium est plus léger et naturellement adapté aux extérieurs très exposés. Nous fabriquons les deux et conseillons selon le lieu.'],
                ['q' => 'Un garde-corps en fer va-t-il rouiller ?', 'a' => 'Pas si la préparation et le traitement sont sérieux. Le risque vient surtout des ouvrages simplement peints sans décapage ni protection adaptée.'],
                ['q' => 'Peut-on intégrer du verre ?', 'a' => 'Oui selon projet, avec panneaux feuilletés sécurisés et structure adaptée. Cela permet de protéger sans fermer visuellement.'],
                ['q' => 'Peut-on remplacer un garde-corps existant ?', 'a' => 'Souvent oui, si le support est sain. Une visite permet de vérifier les ancrages et la faisabilité.'],
                ['q' => 'Quelle hauteur prévoir ?', 'a' => 'La hauteur minimale dépend du contexte et des exigences applicables. Nous cadrons la dimension selon usage résidentiel ou professionnel.'],
                ['q' => 'Combien de temps prend la fabrication et la pose ?', 'a' => 'Le délai dépend du volume et du niveau de finition. Il est annoncé dans le devis.'],
                ['q' => 'Faites-vous des lots pour promoteurs ?', 'a' => 'Oui : balcons, escaliers, toitures terrasses et lots multiples avec planning chantier.'],
            ],
            'finalTitle' => 'Un projet de garde-corps ?',
            'finalSubtitle' => 'Visite et métré gratuits, devis sous 48h pour une demande complète.',
            'serviceType' => 'Garde-corps métallique sur mesure',
        ],
        'staircase' => [
            'path' => 'fer-metal/escalier-metallique',
            'name' => 'Escalier métallique',
            'eyebrow' => 'Fabrication métallique · Escalier',
            'h1' => 'Escalier métallique sur mesure en Tunisie.',
            'h1Accent' => 'La pièce que tous vos invités remarquent en premier.',
            'intro' => 'Dans un duplex, une villa ou un espace commercial, l’escalier n’est pas un détail fonctionnel. Droit, hélicoïdal ou tournant, structure acier avec marches bois, verre ou métal : nous le fabriquons sur mesure dans notre atelier, avec garde-corps assorti si souhaité.',
            'primaryCta' => 'Demander un devis escalier',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $metalImage,
            'proofs' => ['Fabriqué sur mesure', 'Marches bois, verre ou métal', 'Garde-corps assorti', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Sur mesure', 'label' => 'Hauteur, emprise, style et usage.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Marches au choix', 'label' => 'Bois, verre, métal ou béton ciré.', 'icon' => 'fa-solid fa-stairs'],
                ['value' => 'Intérieur & extérieur', 'label' => 'Traitement adapté à l’usage.', 'icon' => 'fa-solid fa-house'],
                ['value' => 'Pose incluse', 'label' => 'Fixations, réglages et finitions.', 'icon' => 'fa-solid fa-screwdriver-wrench'],
            ],
            'contextEyebrow' => 'Pourquoi le métal',
            'contextTitle' => 'L’escalier métallique a changé de registre. Ce n’est plus réservé aux usines.',
            'contextIntro' => 'Les architectes et décorateurs l’adoptent pour villas, duplex et espaces commerciaux : finesse de structure, liberté de forme, combinaison bois ou verre, solidité durable.',
            'benefits' => [
                ['title' => 'Il prend peu de place', 'copy' => 'Structure centrale ou limon latéral permettent une emprise plus fine qu’un escalier béton massif.'],
                ['title' => 'Il se combine avec tout', 'copy' => 'Marches bois pour la chaleur, verre pour la légèreté, métal antidérapant pour extérieur.'],
                ['title' => 'Il dure longtemps', 'copy' => 'Une structure bien traitée conserve solidité et aspect sans entretien lourd.'],
                ['title' => 'Il valorise l’espace', 'copy' => 'Dans une entrée ou un salon, l’escalier devient un élément architectural visible en permanence.'],
            ],
            'typesEyebrow' => 'Nos types d’escaliers',
            'typesTitle' => 'Le bon type selon votre espace et votre configuration.',
            'typesIntro' => 'Le choix dépend de l’espace disponible, de la hauteur à franchir, de la circulation et de l’effet architectural recherché.',
            'types' => [
                ['title' => 'Escalier droit', 'copy' => 'La configuration la plus simple et économique, idéale quand l’espace en longueur est disponible.', 'icon' => 'fa-solid fa-arrow-up-long'],
                ['title' => 'Escalier hélicoïdal', 'copy' => 'Solution compacte et sculpturale pour mezzanines, petits duplex et intérieurs contemporains.', 'icon' => 'fa-solid fa-rotate'],
                ['title' => 'Quart tournant', 'copy' => 'Change de direction à 90°, plus confortable qu’un droit dans un espace contraint.', 'icon' => 'fa-solid fa-turn-up'],
                ['title' => 'Demi-tournant', 'copy' => 'Effet élégant pour grandes entrées, hôtels ou espaces commerciaux représentatifs.', 'icon' => 'fa-solid fa-retweet'],
                ['title' => 'Suspendu', 'copy' => 'Effet aérien et design, à valider selon mur, dalle et calcul de structure.', 'icon' => 'fa-solid fa-cloud'],
                ['title' => 'Escalier extérieur', 'copy' => 'Accès terrasse, toiture ou jardin, avec traitement anti-corrosion et marches antidérapantes.'],
            ],
            'detailEyebrow' => 'Marches & garde-corps',
            'detailTitle' => 'La structure est en acier. Le style se joue sur les marches et le garde-corps.',
            'detailIntro' => 'Notre avantage est de coordonner métal et bois : structure acier, marches bois et garde-corps peuvent être pensés ensemble dans un seul devis.',
            'details' => [
                ['title' => 'Marches bois massif', 'copy' => 'La combinaison la plus demandée : acier solide, bois chaleureux, confort acoustique et visuel.'],
                ['title' => 'Marches verre sécurisé', 'copy' => 'Effet lumineux et spectaculaire pour salons, entrées ou espaces premium.'],
                ['title' => 'Marches métal', 'copy' => 'Tôle larmée ou caillebotis pour usages extérieurs ou style industriel assumé.'],
                ['title' => 'Garde-corps assorti', 'copy' => 'Barreaux, lames, câbles inox, verre ou fer forgé fabriqués dans la même logique esthétique.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Étude & conception', 'copy' => 'Mesure de la hauteur, de l’emprise disponible et vérification des contraintes structurelles.'],
                ['step' => '02', 'title' => 'Plans & devis', 'copy' => 'Conception avec type d’escalier, marches, garde-corps et finitions. Devis détaillé.'],
                ['step' => '03', 'title' => 'Fabrication atelier', 'copy' => 'Structure acier en atelier métal, marches bois en atelier bois si applicable, traitement et finition.'],
                ['step' => '04', 'title' => 'Pose & finitions', 'copy' => 'Pose, fixations, marches, garde-corps, ajustements et garantie atelier.'],
            ],
            'faqTitle' => 'Vos questions sur les escaliers métalliques.',
            'faqs' => [
                ['q' => 'Quel est le prix d’un escalier métallique sur mesure en Tunisie ?', 'a' => 'Le prix dépend du type, des dimensions, des marches, du garde-corps et des contraintes de pose. Un escalier droit simple n’a pas le même budget qu’un suspendu design.'],
                ['q' => 'Quel escalier choisir pour une petite surface ?', 'a' => 'L’hélicoïdal est le plus compact. Si l’espace le permet, un quart tournant est souvent plus confortable au quotidien.'],
                ['q' => 'Un escalier métallique fait-il du bruit ?', 'a' => 'Cela dépend de la conception et des marches. Des marches bois bien fixées et des points d’appui correctement traités limitent fortement les vibrations.'],
                ['q' => 'Peut-on remplacer un escalier béton par un escalier métallique ?', 'a' => 'Oui selon structure existante. Une visite technique vérifie les appuis, la dalle, les fixations et la faisabilité.'],
                ['q' => 'Faut-il un permis pour un escalier intérieur ?', 'a' => 'Si le projet modifie la structure porteuse ou une dalle, des démarches peuvent être nécessaires. À vérifier selon chantier et municipalité.'],
                ['q' => 'Combien de temps prend la fabrication et la pose ?', 'a' => 'Le délai dépend du type, des finitions et de la complexité. Il est annoncé dans le devis.'],
                ['q' => 'Pouvez-vous faire le garde-corps avec l’escalier ?', 'a' => 'Oui, c’est recommandé pour une cohérence visuelle, un seul planning et un seul chantier de pose.'],
                ['q' => 'Quelle est votre spécialité sur les marches ?', 'a' => 'La combinaison structure acier + marches bois est un avantage fort grâce à la coordination entre atelier métal et atelier bois.'],
            ],
            'finalTitle' => 'Un projet d’escalier ?',
            'finalSubtitle' => 'Visite et étude gratuites, devis sous 48h pour une demande complète, fabrication en atelier.',
            'serviceType' => 'Escalier métallique sur mesure',
        ],
    ];

    $data = $pages[$pageKey];
    $breadcrumbs = [
        ['name' => 'Accueil', 'url' => route('home')],
        ['name' => 'Fabrication métallique', 'url' => url('/fer-metal')],
        ['name' => $data['name'], 'url' => url('/' . $data['path'])],
    ];

    $allLinks = collect([
        ['title' => 'Portail fer forgé', 'href' => url('/fer-metal/portail-fer-forge'), 'copy' => 'Battant, coulissant, motorisé.'],
        ['title' => 'Pergola métallique', 'href' => url('/fer-metal/pergola-metallique'), 'copy' => 'Terrasse, jardin, CHR.'],
        ['title' => 'Garde-corps métallique', 'href' => url('/fer-metal/garde-corps'), 'copy' => 'Balcon, escalier, mezzanine.'],
        ['title' => 'Escalier métallique', 'href' => url('/fer-metal/escalier-metallique'), 'copy' => 'Droit, hélicoïdal, suspendu.'],
        ['title' => 'Fabrication métallique', 'href' => url('/fer-metal'), 'copy' => 'Retour au hub métal.'],
        ['title' => 'Aménagement villa & maison', 'href' => url('/projets/amenagement-villa-maison'), 'copy' => 'Projet global maison.'],
    ])->reject(fn ($link) => $link['href'] === url('/' . $data['path']))->values();
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Fabrication métallique', 'item' => url('/fer-metal')],
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
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_18%,rgba(184,138,59,0.16),transparent_34%),radial-gradient(circle_at_86%_18%,rgba(72,54,35,0.14),transparent_30%)]"></div>
    <div class="container relative mx-auto grid gap-10 px-4 py-14 lg:grid-cols-[0.92fr_1.08fr] lg:items-center lg:py-20">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-[#d8c7af] bg-white/72 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#8b6426]">
                <i class="fa-solid fa-fire-flame-curved"></i>
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
                <a href="#realisations-metal" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white/78 px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834] hover:bg-white">
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
                <div class="relative min-h-[360px] overflow-hidden rounded-[30px] bg-cover bg-center lg:min-h-[540px]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.68)), url('{{ $data['heroImage'] }}');">
                    <div class="absolute bottom-6 left-6 right-6 rounded-[26px] border border-white/18 bg-[#171411]/72 p-5 text-white backdrop-blur">
                        <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Fabrication métallique</div>
                        <p class="mt-2 text-sm leading-6 text-white/78">Étude, découpe, assemblage, traitement, finition et pose avec un interlocuteur clair.</p>
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
                        <i class="{{ $type['icon'] ?? 'fa-solid fa-fire-flame-curved' }}"></i>
                    </span>
                    <h3 class="font-display mt-6 text-xl font-extrabold text-[#171411]">{{ $type['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $type['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4">
        <div class="grid gap-10 lg:grid-cols-[0.92fr_1.08fr] lg:items-start">
            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">{{ $data['detailEyebrow'] }}</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold sm:text-4xl">{{ $data['detailTitle'] }}</h2>
                <p class="mt-5 text-lg leading-8 text-white/72">{{ $data['detailIntro'] }}</p>
                <a href="{{ $devisUrl }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-[#d5b170] px-6 py-3 text-sm font-extrabold text-[#171411]">
                    Étudier mon projet
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                @foreach($data['details'] as $detail)
                    <article class="rounded-[28px] border border-white/10 bg-white/[0.06] p-6">
                        <h3 class="font-display text-xl font-extrabold text-white">{{ $detail['title'] }}</h3>
                        <p class="mt-4 text-sm leading-7 text-white/70">{{ $detail['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section id="realisations-metal" class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Réalisations métalliques</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Quelques projets liés à cette gamme.</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            @foreach([
                ['type' => $data['name'], 'place' => 'Sur mesure', 'image' => $data['heroImage'], 'copy' => 'Fabrication atelier, traitement, finition et pose sur site.'],
                ['type' => 'Projet extérieur', 'place' => 'Villa & maison', 'image' => $pergolaImage, 'copy' => 'Ouvrage métallique exposé, pensé pour durer dehors.'],
                ['type' => 'Projet professionnel', 'place' => 'Commercial', 'image' => $restaurantImage, 'copy' => 'Structure coordonnée pour usage intensif et rendu propre.'],
            ] as $realization)
                <article class="relative min-h-[320px] overflow-hidden rounded-[34px] bg-cover bg-center p-6" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.82)), url('{{ $realization['image'] }}');">
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <span class="inline-flex w-max rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-bold text-[#e7c98d] backdrop-blur">{{ $realization['place'] }}</span>
                        <div class="text-white">
                            <h3 class="font-display text-2xl font-extrabold">{{ $realization['type'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-white/76">{{ $realization['copy'] }}</p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Le processus</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Du premier métré à la pose, en 4 étapes.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-4">
            @foreach($data['process'] as $step)
                <article class="rounded-[30px] border border-[#eadfce] bg-white p-6">
                    <div class="font-display text-5xl font-extrabold text-[#a47834]/20">{{ $step['step'] }}</div>
                    <h3 class="font-display mt-5 text-xl font-extrabold text-[#171411]">{{ $step['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $step['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Questions fréquentes</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $data['faqTitle'] }}</h2>
        </div>

        <div class="mx-auto max-w-4xl divide-y divide-[#eadfce] rounded-[34px] border border-[#eadfce] bg-[#fbf7ee] p-2">
            @foreach($data['faqs'] as $faq)
                <details class="group rounded-[26px] px-5 py-4 open:bg-white" @if($loop->first) open @endif>
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
                WhatsApp atelier métal
            </a>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-14 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="mb-7 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Explorer la fabrication métallique</div>
            <h3 class="font-display mt-3 text-2xl font-extrabold text-[#171411] sm:text-3xl">Nos autres ouvrages métalliques.</h3>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
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

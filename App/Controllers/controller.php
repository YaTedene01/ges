<?php
namespace App\Controllers;
require_once __DIR__.'/../Services/session.service.php';
require_once __DIR__ . '/PromoController.php';
require_once __DIR__ . '/../Services/database.php';

function showActivePromotionReferentiels() {
    $activePromotion = getActivePromotion();

    if ($activePromotion) {
        $referentiels = getReferentielsByPromotion($activePromotion['id']);
        error_log("Promotion active : " . json_encode($activePromotion));
    } else {
        $referentiels = []; // Aucun référentiel si aucune promotion active
        error_log("Aucun référentiel trouvé pour la promotion active.");
    }

    render_view('referentiels/referentiels_active', [
        'pageTitle' => 'Référentiels de la Promotion Active',
        'referentiels' => $referentiels,
        'activePromotion' => $activePromotion,
    ]);
}

function showPromotions() {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 4;
    $searchTerm = $_GET['search'] ?? '';

    // Si aucun terme de recherche n'est fourni, ne retourner aucune promotion
    if (empty($searchTerm)) {
        $promos = [];
        $totalItems = 0;
        $totalPages = 0;
    } else {
        // Récupérer les promotions filtrées
        $promos = searchPromotions($searchTerm);
        $totalItems = count($promos);
        $totalPages = ceil($totalItems / $perPage);
        $offset = ($page - 1) * $perPage;

        // Extraire les promotions pour la page actuelle
        $promos = array_slice($promos, $offset, $perPage);
    }

    // Transmettre les données à la vue
    render_view('promotions/index', [
        'pageTitle' => 'Liste des Promotions',
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'promotions' => $promos,
        'totalItems' => $totalItems,
        'itemsPerPage' => $perPage,
        'searchTerm' => $searchTerm,
    ]);
    // Correction ici : utiliser $promos au lieu de $currentPromos
    error_log("Promotions transmises à la vue : " . json_encode($promos));
}

function showReferentiels() {
    // Charger les données nécessaires (par exemple, depuis un fichier JSON)
    $filePath = __DIR__ . '/../data/global.json';
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    // Récupérer les référentiels
    $referentiels = $data['referentiels'] ?? [];

    // Rendre la vue
    render_view('referentiels/index', [
        'pageTitle' => 'Tous les Référentiels',
        'referentiels' => $referentiels,
    ]);
}

function addReferentiel() {
    // Chemin vers le fichier JSON
    $filePath = __DIR__ . '/../data/global.json';

    // Charger le contenu du fichier JSON
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    // Débogage : Vérifiez les données reçues
    error_log("Données reçues : " . print_r($_POST, true));

    // Récupérer les données du formulaire
    $nom = $_POST['nom'] ?? null;
    $description = $_POST['description'] ?? null;
    $capacite = $_POST['capacite'] ?? null;
    $sessions = $_POST['sessions'] ?? null;
    $image = $_FILES['photo']['name'] ?? '/assets/images/default.jpeg'; // Image par défaut

    // Valider les données
    if (!$nom || !$description || !$capacite || !$sessions) {
        die('Tous les champs obligatoires doivent être remplis.');
    }

    // Générer un ID unique pour le nouveau référentiel
    $newReferentiel = [
        'id' => 'ref_' . uniqid(),
        'nom' => $nom,
        'description' => $description,
        'capacite' => $capacite,
        'sessions' => $sessions,
        'image' => $image
    ];

    // Ajouter le nouveau référentiel dans la section "referentiels"
    $data['referentiels'][] = $newReferentiel;

    // Sauvegarder les modifications dans le fichier JSON
    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

    // Rediriger vers la liste des référentiels
    header('Location: /referentiels');
    exit;
}

// Redirection
function redirect($path, $params = []) {
    $url = $path;
    if (!empty($params)) {
        $query = http_build_query($params);
        $url .= "?{$query}";
    }

    error_log("REDIRECTION VERS : $url"); // pour vérifier
    header("Location: {$url}");
    exit;
}

function is_authenticated() {
    // Vérifiez si l'utilisateur est connecté en vérifiant une variable de session
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

function require_auth() {
    if (!is_authenticated()) {
        // Stocker l'URL originale pour redirection après login
        session_set('redirect_after_login', $_SERVER['REQUEST_URI']);
        redirect('/login');
    }
}

function require_role($roles) {
    require_auth();
    $user = get_current_user();
    $roles = is_array($roles) ? $roles : [$roles];
    if (!in_array($user['role'], $roles)) {
        echo 'error', 'Vous n\'avez pas les permissions nécessaires pour accéder à cette page.';
        redirect('/dashboard');
    }
}

// Rendu de vue
function render_view($template, $data = []) {
    extract($data); // Extraire les données pour les rendre disponibles dans la vue

    // Récupérer la promotion active
    $activePromotion = getActivePromotion();

    // Inclure le layout global
    $content = __DIR__ . "/../Views/$template.php";

    if (file_exists($content)) {
        include __DIR__ . '/../Views/layout/base.layout.php';
    } else {
        die("La vue $template n'existe pas.");
    }
}

// Rendu avec layouted content (pour votre système actuel)
function render_with_layout($viewPath, $pageTitle, $currentPage = '') {
    return [
        'currentPage' => $currentPage,
        'content' => $viewPath,
        'contentHeader' => "<h2>{$pageTitle}</h2>"
    ];
}

function showApprenants() {
    // Charger les données des apprenants (par exemple, depuis un fichier JSON ou une base de données)
    $filePath = __DIR__ . '/../data/global.json';
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    $apprenants = $data['apprenants'] ?? []; // Assurez-vous que la clé 'apprenants' existe dans votre fichier JSON

    // Rendre la vue avec les données des apprenants
    render_view('Apprennants/index', [
        'pageTitle' => 'Liste des Apprenants',
        'apprenants' => $apprenants,
    ]);
}

function showAffReferentiel() {
    $filePath = __DIR__ . '/../data/global.json';
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    error_log("Données des référentiels affectés : " . print_r($data['referentiels_affectes'] ?? [], true));
    error_log("Données des référentiels non affectés : " . print_r($data['referentiels_non_affectes'] ?? [], true));

    render_view('referentiels/affreferentiel', [
        'pageTitle' => 'Affecter/Désaffecter des Référentiels',
        'referentielsAffectes' => $data['referentiels_affectes'] ?? [],
        'referentielsNonAffectes' => $data['referentiels_non_affectes'] ?? [],
    ]);
}

function showAjoutApprenant() {
    // Charger les données nécessaires si besoin (par exemple, des référentiels)
    $filePath = __DIR__ . '/../data/global.json';
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    // Rendre la vue
    render_view('Apprennants/ajoutApprenant', [
        'pageTitle' => 'Ajouter un Apprenant',
        'referentiels' => $data['referentiels'] ?? [],
    ]);
}


function searchApprenants() {
    $matricule = $_GET['matricule'] ?? '';
    $classe = $_GET['classe'] ?? '';
    $statut = $_GET['statut'] ?? '';

    $filePath = __DIR__ . '/../data/global.json';
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    $apprenants = $data['apprenants'] ?? [];

    // Filtrer les apprenants
    $filtered = array_filter($apprenants, function ($apprenant) use ($matricule, $classe, $statut) {
        return (!$matricule || strpos($apprenant['matricule'], $matricule) !== false) &&
               (!$classe || $apprenant['referentiel'] === $classe) &&
               (!$statut || $apprenant['statut'] === $statut);
    });

    return $filtered;
}

function paginateApprenants($apprenants, $page, $limit) {
    $total = count($apprenants);
    $start = ($page - 1) * $limit;
    $end = min($start + $limit, $total);

    return [
        'apprenants' => array_slice($apprenants, $start, $limit),
        'total' => $total,
        'start' => $start + 1,
        'end' => $end,
        'totalPages' => ceil($total / $limit),
        'currentPage' => $page,
    ];
}

function affecterReferentiel() {
    $referentielId = $_POST['referentiel_id'] ?? null;

    if (!$referentielId) {
        die('ID du référentiel manquant.');
    }

    $filePath = __DIR__ . '/../data/global.json';
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    // Trouver le référentiel dans les non affectés
    foreach ($data['referentiels_non_affectes'] as $key => $referentiel) {
        if ($referentiel['id'] === $referentielId) {
            // Déplacer le référentiel vers les affectés
            $data['referentiels_affectes'][] = $referentiel;
            unset($data['referentiels_non_affectes'][$key]);
            break;
        }
    }

    // Sauvegarder les modifications
    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

    // Rediriger vers la page
    header('Location: /referentiels/affreferentiel');
    exit;
}

function desaffecterReferentiel() {
    $referentielId = $_POST['referentiel_id'] ?? null;

    if (!$referentielId) {
        die('ID du référentiel manquant.');
    }

    $filePath = __DIR__ . '/../data/global.json';
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    // Trouver le référentiel dans les affectés
    foreach ($data['referentiels_affectes'] as $key => $referentiel) {
        if ($referentiel['id'] === $referentielId) {
            // Déplacer le référentiel vers les non affectés
            $data['referentiels_non_affectes'][] = $referentiel;
            unset($data['referentiels_affectes'][$key]);
            break;
        }
    }

    // Sauvegarder les modifications
    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

    // Rediriger vers la page
    header('Location: /referentiels/affreferentiel');
    exit;
}

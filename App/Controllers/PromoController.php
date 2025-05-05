<?php
// PromotionController.php
namespace App\Controllers;

use App\Enums\PromotionAttribute;
use App\Enums\Promotion_Model_Key;
use App\Enums\SuccessCode;
use App\Enums\ModelFunction;
use App\Enums\DataKey;
use App\Services as Services;

require_once __DIR__.'/../Services/validator.service.php';
require_once __DIR__.'/../Services/session.service.php';
require_once __DIR__.'/controller.php';

$model = require __DIR__.'/../Models/Promo.model.php';
function handle_file_upload($file) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new \Exception("Erreur lors de l'upload du fichier.");
    }

    // Définir le répertoire de destination
    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Générer un nom unique pour le fichier
    $fileName = uniqid() . '_' . basename($file['name']);
    $uploadPath = $uploadDir . $fileName;

    // Déplacer le fichier téléchargé
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new \Exception("Impossible de déplacer le fichier téléchargé.");
    }

    return '/uploads/' . $fileName; // Retourner le chemin relatif
}
function create_promotion() {
    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
        // Charger les messages d'erreur
        $error_messages = include __DIR__ . '/../lang/error.fr.php';
        $errors = [];
        
        // Validation des champs
        if (empty($_POST['nom'])) {
            $errors[] = $error_messages['promotion']['nom_required'];
        }
        
        if (empty($_POST['datedebut'])) {
            $errors[] = $error_messages['promotion']['datedebut_required'];
        }
        
        if (empty($_POST['datefin'])) {
            $errors[] = $error_messages['promotion']['datefin_required'];
        }
        
        if (empty($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = $error_messages['promotion']['photo_required'];
        }
        
        if (empty($_POST['referentiels'])) {
            $errors[] = $error_messages['promotion']['referentiels_required'];
        }
        
        // S'il y a des erreurs
        if (!empty($errors)) {
            // Stocker les erreurs et les anciennes valeurs en session
            session_set('promotion_errors', $errors);
            session_set('old_input', $_POST);
            
            // Rediriger vers le formulaire
            redirect('/promotions?action=add');
            exit;
        }
        
        // Si pas d'erreurs, traiter le formulaire
        // ... code pour créer la promotion ...
        
        // Rediriger avec un message de succès
        session_set('success_message', ['content' => 'Promotion créée avec succès']);
        redirect('/promotions');
        exit;
    }

}






function get_all_promotions() {
    $filePath = __DIR__ . '/../data/global.json';
    if (!file_exists($filePath)) {
        error_log("Fichier global.json introuvable.");
        return [];
    }

    $data = json_decode(file_get_contents($filePath), true);
    return $data['promotions'] ?? [];
}

function get_nbr_promotions() {
    global $model; // Correction 3 (c'était $fonctions_models mais ton modèle est dans $model)

    return $model[ModelFunction::GET_NBR->value](DataKey::PROMOTIONS);
}

function getActivePromotion() {
    // Chemin vers le fichier JSON
    $filePath = __DIR__ . '/../data/global.json';

    // Charger le contenu du fichier JSON
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    // Rechercher la promotion active
    foreach ($data['promotions'] as $promotion) {
        if ($promotion['statut'] === 'active') {
            return $promotion;
        }
    }

    return null; // Aucune promotion active trouvée
}
$activePromotion = getActivePromotion();
$data['activePromotion'] = $activePromotion;

function searchPromotions($searchTerm = '') {
    $promotions = get_all_promotions();

    // Si aucun terme de recherche n'est fourni, retourner toutes les promotions
    if (empty($searchTerm)) {
        return $promotions;
    }

    // Filtrer les promotions en fonction du terme de recherche
    $filteredPromotions = array_filter($promotions, function ($promotion) use ($searchTerm) {
        return stripos($promotion['nom'], $searchTerm) !== false;
    });

    return $filteredPromotions; // Retourne un tableau vide si aucune promotion ne correspond
}

function getReferentielsByPromotion($promotionId) {
    $filePath = __DIR__ . '/../data/global.json';
    if (!file_exists($filePath)) {
        error_log("Fichier global.json introuvable.");
        return [];
    }

    $data = json_decode(file_get_contents($filePath), true);
    if (!isset($data['referentiels']) || !is_array($data['referentiels'])) {
        error_log("Structure incorrecte dans global.json.");
        return [];
    }

    return array_filter($data['referentiels'], function ($referentiel) use ($promotionId) {
        return $referentiel['promotion_id'] === $promotionId;
    });
}

function getPaginatedPromotions($page = 1, $perPage = 3) {
    $filePath = __DIR__ . '/../data/global.json';
    if (!file_exists($filePath)) {
        error_log("Fichier global.json introuvable.");
        return [
            'promotions' => [],
            'total' => 0,
            'perPage' => $perPage,
            'currentPage' => $page,
            'totalPages' => 0,
        ];
    }

    $data = json_decode(file_get_contents($filePath), true);
    $promotions = $data['promotions'] ?? [];
    $offset = ($page - 1) * $perPage;
    $paginatedPromotions = array_slice($promotions, $offset, $perPage);

    return [
        'promotions' => $paginatedPromotions,
        'total' => count($promotions),
        'perPage' => $perPage,
        'currentPage' => $page,
        'totalPages' => ceil(count($promotions) / $perPage),
    ];
}

function togglePromotionStatus() {
    try {
        if (!isset($_GET['promotion_id'])) {
            throw new \Exception('Paramètre promotion_id manquant');
        }

        $id = $_GET['promotion_id'];
        $filePath = __DIR__ . '/../data/global.json';

        if (!file_exists($filePath)) {
            throw new \Exception("Fichier global.json introuvable.");
        }

        $data = json_decode(file_get_contents($filePath), true);

        foreach ($data['promotions'] as &$promotion) {
            $promotion['statut'] = 'inactive';
        }

        $promotionIndex = array_search($id, array_column($data['promotions'], 'id'));
        if ($promotionIndex === false) {
            throw new \Exception("Promotion introuvable.");
        }

        $data['promotions'][$promotionIndex]['statut'] = 'active';

        $activePromotion = $data['promotions'][$promotionIndex];
        unset($data['promotions'][$promotionIndex]);
        array_unshift($data['promotions'], $activePromotion);

        if (file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT)) === false) {
            throw new \Exception("Échec de la sauvegarde dans global.json.");
        }

        error_log("Promotion activée et réorganisée : " . json_encode($data['promotions'][0]));

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;

    } catch (\Exception $e) {
        session_set('error_message', $e->getMessage()); // Appel corrigé
        redirect('/promotions'); // Appel corrigé
    }
}
require_once __DIR__ . '/../Services/lang.service.php';
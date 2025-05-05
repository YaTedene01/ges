<?php
namespace App\Controllers;

// Inclure les dépendances nécessaires
require_once __DIR__.'/PromoController.php';
require_once __DIR__.'/controller.php';

/**
 * Affiche la liste des apprenants
 */
function list_apprenants() {
    // Rediriger vers la page d'ajout pour l'instant
    header("Location: /apprenants/ajout");
    exit;
}

/**
 * Affiche le formulaire d'ajout d'apprenant
 */
function show_apprenant_form() {
    error_log("Fonction show_apprenant_form() appelée");
    
    // Récupérer les promotions pour la liste déroulante
    $promos = get_all_promotions() ?? [];
    
    // Inclure la vue du formulaire
    require __DIR__ . '/../Views/apprenants/ajoutApprenant.php';
}

/**
 * Traite la soumission du formulaire d'ajout d'apprenant
 */
function create_apprenant() {
    error_log("Fonction create_apprenant() appelée");
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validation des champs
        $errors = [];
        
        // Validation du nom
        if (empty($_POST['nom'])) {
            $errors['nom'] = "Le nom est obligatoire";
        }
        
        // Validation du prénom
        if (empty($_POST['prenom'])) {
            $errors['prenom'] = "Le prénom est obligatoire";
        }
        
        // Validation de l'email
        if (empty($_POST['email'])) {
            $errors['email'] = "L'email est obligatoire";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'email n'est pas valide";
        }
        
        // Validation du téléphone
        if (empty($_POST['telephone'])) {
            $errors['telephone'] = "Le téléphone est obligatoire";
        }
        
        // Validation de la date de naissance
        if (empty($_POST['date_naissance'])) {
            $errors['date_naissance'] = "La date de naissance est obligatoire";
        }
        
        // Validation de la promotion
        if (empty($_POST['promotion'])) {
            $errors['promotion'] = "La promotion est obligatoire";
        }
        
        // S'il y a des erreurs
        if (!empty($errors)) {
            // Stocker les erreurs et les anciennes valeurs en session
            $_SESSION['apprenant_errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            
            // Rediriger vers le formulaire
            header("Location: /apprenants/ajout");
            exit;
        }
        
        // Si pas d'erreurs, traiter le formulaire
        // (Code pour enregistrer l'apprenant dans la base de données)
        
        // Rediriger avec un message de succès
        $_SESSION['success_message'] = ['content' => 'Apprenant ajouté avec succès'];
        header("Location: /apprenants");
        exit;
    } else {
        // Si ce n'est pas une soumission de formulaire, afficher le formulaire
        show_apprenant_form();
    }
}

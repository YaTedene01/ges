<?php
namespace App\Controllers;

// Fonction pour créer un référentiel
function create_referentiel() {
    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
        // Charger les messages d'erreur
        $error_messages = include __DIR__ . '/../lang/error.fr.php';
        $errors = [];
        
        // Validation des champs
        if (empty($_POST['nom'])) {
            $errors['nom'] = $error_messages['referentiel']['nom_required'];
        }
        
        if (empty($_POST['description'])) {
            $errors['description'] = $error_messages['referentiel']['description_required'];
        }
        
        if (empty($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors['image'] = $error_messages['referentiel']['image_required'];
        }
        
        if (empty($_POST['capacite'])) {
            $errors['capacite'] = $error_messages['referentiel']['capacite_required'];
        } elseif (!is_numeric($_POST['capacite']) || intval($_POST['capacite']) <= 0) {
            $errors['capacite'] = $error_messages['referentiel']['capacite_numeric'];
        }
        
        // S'il y a des erreurs
        if (!empty($errors)) {
            // Stocker les erreurs et les anciennes valeurs en session
            session_set('referentiel_errors', $errors);
            session_set('old_input', $_POST);
            
            // Rediriger vers le formulaire
            redirect('/referentiels/create');
            exit;
        }
        
        // Si pas d'erreurs, traiter le formulaire
        // ... code pour créer le référentiel ...
        
        // Rediriger avec un message de succès
        session_set('success_message', ['content' => 'Référentiel créé avec succès']);
        redirect('/referentiels');
        exit;
    }
    
    // Si ce n'est pas une soumission de formulaire, afficher le formulaire
    require __DIR__ . '/../Views/referentiels/create.php';
}

// Fonction pour afficher le formulaire de création
function show_create_form() {
    require __DIR__ . '/../Views/referentiels/create.php';
}
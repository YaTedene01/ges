<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion
header("Location: login.php");
exit;
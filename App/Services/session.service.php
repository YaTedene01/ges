<?php
// Assurez-vous que ces fonctions sont correctement définies

// Fonction pour initialiser la session
function session_init() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Fonction pour vérifier si une clé existe dans la session
function session_has($key) {
    error_log("session_has appelé pour la clé: $key");
    
    $keys = explode('.', $key);
    $value = $_SESSION;
    
    foreach ($keys as $segment) {
        if (!isset($value[$segment])) {
            error_log("session_has: clé $key non trouvée");
            return false;
        }
        $value = $value[$segment];
    }
    
    error_log("session_has: clé $key trouvée");
    return true;
}

// Fonction pour récupérer une valeur de la session
function session_get($key, $default = null) {
    error_log("session_get appelé pour la clé: $key");
    
    $keys = explode('.', $key);
    $value = $_SESSION;
    
    foreach ($keys as $segment) {
        if (!isset($value[$segment])) {
            error_log("session_get: clé $key non trouvée, retourne la valeur par défaut");
            return $default;
        }
        $value = $value[$segment];
    }
    
    error_log("session_get: clé $key trouvée, valeur: " . print_r($value, true));
    return $value;
}

// Fonction pour définir une valeur dans la session
function session_set($key, $value) {
    error_log("session_set appelé pour la clé: $key avec la valeur: " . print_r($value, true));
    
    $keys = explode('.', $key);
    $session = &$_SESSION;
    
    foreach ($keys as $segment) {
        if (!isset($session[$segment]) || !is_array($session[$segment])) {
            $session[$segment] = [];
        }
        $session = &$session[$segment];
    }
    
    $session = $value;
    error_log("Session après session_set: " . print_r($_SESSION, true));
}

// Fonction pour supprimer une valeur de la session
function session_remove($key) {
    $keys = explode('.', $key);
    $session = &$_SESSION;
    
    foreach ($keys as $i => $segment) {
        if (!isset($session[$segment])) {
            return;
        }
        
        if ($i === count($keys) - 1) {
            unset($session[$segment]);
            return;
        }
        
        $session = &$session[$segment];
    }
}

function get_old_input($key, $default = '') {
    $old = session_get('old_input', []);
    return htmlspecialchars($old[$key] ?? $default);
}

function clear_session_messages() {
    session_remove('validation_errors');
    session_remove('old_input');
    session_remove('success_message');
}

// App/Services/session.service.php

function session_destroy_all(): void {
    session_init();
    
    // Vide les données de session
    $_SESSION = [];

    // Supprime le cookie de session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Détruit la session
    session_destroy();
}
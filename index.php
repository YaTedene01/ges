<?php
// Fichier: public/index.php
ini_set('display_startup_errors', 1);
// Configuration des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/../storage/logs/error.log');

// Initialisation des services
require_once __DIR__.'/../App/Services/session.service.php';
session_init();

// Chargement des routes
$routes = require __DIR__ . '/../App/route/route.web.php';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Recherche directe de la route
$routeKey = "$method $uri";
// Ajoutez cette définition en haut du fichier
if (!function_exists('redirect')) {
    function redirect($url) {
        header("Location: $url");
        exit;
    }
}
if (array_key_exists($routeKey, $routes)) {
    try {
        $callback = $routes[$routeKey];

        // Vérifiez si le callback est au format "Class@method"
        if (is_string($callback) && strpos($callback, '@') !== false) {
            [$class, $method] = explode('@', $callback);
            if (class_exists($class) && method_exists($class, $method)) {
                $callback = [$class, $method];
            } else {
                throw new Exception("La classe ou la méthode spécifiée n'existe pas : $callback");
            }
        }

        // Exécution du handler
        $data = call_user_func($callback);

        // Gestion des vues protégées
        if (isset($data['content'])) {
            extract($data);
            require __DIR__ . '/../App/Views/layout/base.layout.php';
        }
    } catch (Exception $e) {
        error_log("Route error: " . $e->getMessage());
        session_set('error_message', 'Une erreur technique est survenue');
        redirect('/500');
    }
} else {
    // Route non trouvée
    redirect('/404');
}
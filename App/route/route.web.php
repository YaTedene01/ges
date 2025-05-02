<?php
require_once __DIR__.'/../Models/Model.php';
require_once __DIR__.'/../Controllers/controller.php';
require_once __DIR__.'/../Services/session.service.php';
require_once __DIR__.'/../Controllers/PromoController.php';
require_once __DIR__.'/../Controllers/UserController.php';

use App\Controllers as User;
use App\Controllers as Promo;

function checkAuth() {
    session_init();
    if (!session_has('user')) {
        error_log('Utilisateur non authentifié');
        header('Location: /'); // Correction : redirection correcte
        exit;
    }
}

function protectedView(string $currentPage, string $viewPath, string $headerTitle) {
    checkAuth();
    return [
        'currentPage' => $currentPage,
        'content' => __DIR__.'/../Views/'.$viewPath,
        'contentHeader' => '<h2>'.$headerTitle.'</h2>'
    ];
}

return [
    'GET /' => function() {
        session_init();
        if (session_has('user')) {
            header('Location: ' . match(session_get('user.role')) {
                'admin' => '/dashboard',
                'apprenant' => '/apprenant/dashboard',
                default => '/'
            });
            exit;
        }
        require_once __DIR__.'/../Views/auth/login.php';
        exit;
    },

    'POST /' => fn() => User\login(),

    'GET /dashboard' => fn() => protectedView(
        'dashboard',
        'dashboard.php', 
        'Bienvenue sur votre tableau de bord'
    ),

    'GET /promotions' => function () {
    session_init();
    checkAuth();
    global $data;

    // Vérifiez explicitement si les clés existent
    $status = isset($_GET['status']) ? $_GET['status'] : null;
    $search = isset($_GET['search']) ? $_GET['search'] : null;

    $data['promotions'] = Promo\get_all_promotions($status, $search);
    $data['action'] = $_GET['action'] ?? null; // Ajout du paramètre action

    return protectedView('promotions', 'promotions/index.php', 'Gestion des Promotions');
},

    'GET /promotions/toggle' => fn() => Promo\togglePromotionStatus(),

    'POST /promotions/create' => 'App\Controllers\PromoController@create',
    // 'POST /promotions/delete' => fn() => Promo\deletePromotion(),

    'GET /referentiels' => function () {
        App\Controllers\showActivePromotionReferentiels();
    },

    'GET /referentiels/create' => function () {
        session_init();
        checkAuth();
        return protectedView('referentiels', 'referentiels/create.php', 'Créer un Référentiel');
    },
    'POST /referentiels/create' => fn() => App\Controllers\addReferentiel(),

    'GET /referentiels/index' => function () {
        App\Controllers\showReferentiels();
    },

    'GET /referentiels/affreferentiel' => function () {
        App\Controllers\showAffReferentiel();
    },

    'POST /referentiels/affecter' => function () {
        App\Controllers\affecterReferentiel();
    },

    'POST /referentiels/desaffecter' => function () {
        App\Controllers\desaffecterReferentiel();
    },

    'GET /apprenants' => function () {
        App\Controllers\showApprenants();
    },

    'GET /apprenants/ajoutApprenant' => function () {
        App\Controllers\showAjoutApprenant();
    },

    'POST /apprenants/create' => function () {
        App\Controllers\createApprenant();
    },

    'GET /forgot-password' => fn() => User\forgotPassword(),
    'POST /forgot-password' => fn() => User\forgotPassword(),

    'GET /404' => function() {
        http_response_code(404);
        return ['content' => __DIR__.'/../Views/errors/404.php'];
    },

    'GET /500' => function() {
        http_response_code(500);
        return ['content' => __DIR__.'/../Views/promotions/index.php'];
    },
];
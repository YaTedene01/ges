<?php

define('APP_BASE_DIR', realpath(__DIR__ . '/..'));

return [
    'services' => [
        'validator' => APP_BASE_DIR . '/Services/validator.service.php',
        'session' => APP_BASE_DIR . '/Services/session.service.php'
    ],
    'controller' => APP_BASE_DIR . '/controller.php',
    'models' => [
        'promo' => APP_BASE_DIR . '/Models/Promo.model.php'
    ],
    'uploads' => APP_BASE_DIR . '/public/uploads/promotions/'
];
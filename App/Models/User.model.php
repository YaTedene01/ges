<?php
// App/Models/User.model.php

namespace App\Models;

require_once __DIR__.'/../enums.php';
require_once __DIR__.'/Model.php';
require_once __DIR__ . '/../Models/User.model.php';

use App\Enums\DataKey;
use App\Enums\ModelFunction;
use App\Enums\UserModelKey;

return [
    UserModelKey::AUTHENTICATE->value => function(string $login, string $password) {
        $model = require __DIR__.'/Model.php';
        // Vérification de l'existence de la fonction
        if (!isset($model[ModelFunction::GET_ALL->value])) {
            throw new \RuntimeEXCEPTION('Fonction GET_ALL non trouvée');
        }
        $users = $model[ModelFunction::GET_ALL->value](DataKey::USERS);
        
        // Validation des entrées
        $filtered = array_filter($users, function($u) use ($login) {
            return isset($u['matricule'], $u['email'], $u['password']) 
                && ($u['matricule'] === $login || $u['email'] === $login);
        });

        if ($user = reset($filtered)) {
            return ($password === $user['password']) ? $user : null;
            // return password_verify($password, $user['password']) ? $user : null;
        }
        
        return null;
    },

    UserModelKey::GET_BY_ID->value => function(string $id) {
        $model = require __DIR__.'/Model.php';
        $users = $model[ModelFunction::GET_ALL->value](DataKey::USERS);

        return array_reduce($users, function($found, $user) use ($id) {
            return $found ?? ((isset($user['id']) && $user['id'] === $id) ? $user : null);      
        });
    },
   

    UserModelKey::UPDATE_PASSWORD->value => function($userId, $newPassword) {
        $model = require __DIR__.'/Model.php';
        $users = $model[ModelFunction::GET_ALL->value](DataKey::USERS);
    
        // Vérification de l'utilisateur
        $user = array_reduce($users['users'], function ($found, $u) use ($userId) {
            return $found ?? (($u['id'] === $userId) ? $u : null);
        });
    
        if (!$user) {
            error_log("Utilisateur non trouvé: $userId");
            return false;
        }
    
        $userIndex = array_search($userId, array_column($users['users'], 'id'));
    
        if ($userIndex === false) {
            error_log("Index utilisateur non trouvé: $userId");
            return false;
        }
    
        // Mise à jour du mot de passe (avec hash optionnel)
        $users['users'][$userIndex]['password'] = $newPassword;
        // $users['users'][$userIndex]['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
    
        return $model[ModelFunction::SAVE->value](DataKey::USERS, $users);
    }
];
function redirect($path, $params = []) {
    $url = $path;
    if (!empty($params)) {
        $query = http_build_query($params);
        $url .= "?{$query}";
    }

    header("Location: {$url}");
    exit;
}
function forgotPassword() {
    session_init();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {      
            $login = trim($_POST['login'] ?? '');
            $newPassword = trim($_POST['new_password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');          
            if (empty($login) || empty($newPassword) || empty($confirmPassword)) {
                throw new \EXCEPTION('required_field');
            }  
            if ($newPassword !== $confirmPassword) {
                throw new \EXCEPTION('password_mismatch');
            }   
            require_once __DIR__.'/../Models/User.model.php';
            $user = findUserByLogin($login);
            
            if (!$user) {
                throw new \EXCEPTION('user_not_found');
            }

            $success = $userModel[UserModelKey::UPDATE_PASSWORD->value]($user['id'], $newPassword);
            
            if (!$success) {
                throw new \EXCEPTION('update_failed');
            }
            session_set('login_success', 'Mot de passe mis à jour avec succès');
            redirect('/');
            
        } catch (\EXCEPTION $e) {    
            $errorFile = __DIR__.'/error.controller.php';
            error_log('Loading error file: ' . $errorFile);   
            $errors = null;
            if (file_exists($errorFile)) {
                $errors = require $errorFile;
                if (is_array($errors)) {
                }
            } 
            $errorMessage = 'Erreur inconnue';
            if (is_array($errors) && isset($errors[$e->getMessage()])) {
                $errorMessage = $errors[$e->getMessage()];
            }     
            error_log('Final error message: ' . $errorMessage);
            session_set('forgot_password_errors', [$errorMessage]);
            session_set('old_input', ['login' => $login ?? '']);
        }
    }
    
    require __DIR__.'/../Views/auth/forgot_password.php';
    session_remove('forgot_password_errors');
}

function findUserByLogin($login) {
    $filePath = __DIR__ . '/../data/users.json';

    if (!file_exists($filePath)) {
        return null;
    }

    $users = json_decode(file_get_contents($filePath), true);

    foreach ($users as $user) {
        if ($user['login'] === $login) {
            return $user;
        }
    }

    return null;
}
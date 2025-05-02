<?php
// UserController.php
namespace App\Controllers;

use Exception;
use App\Enums\UserModelKey;

require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../Services/session.service.php';

function login() 
{
    session_init();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userModel = require __DIR__ . '/../Models/User.model.php';
        $login = trim($_POST['login']);
        $password = trim($_POST['password']);

        try {   
            if (empty($login) || empty($password)) {
                throw new Exception('required_field');
            }

            $user = $userModel[UserModelKey::AUTHENTICATE->value]($login, $password);
            error_log("Auth result: " . json_encode($user));

            if (empty($user) || !is_array($user)) {
                throw new Exception('invalid_credentials');
            }

            if (!isset($user['id'], $user['role'], $user['matricule'])) {
                throw new Exception('invalid_user_data');
            }

            session_set('user', [
                'id' => $user['id'],
                'role' => (string)$user['role'],
                'nom' => (string)($user['nom'] ?? ''),
                'matricule' => (string)$user['matricule']
            ]);

            error_log("Utilisateur authentifié: " . print_r($user, true));
            error_log("Session avant redirection: " . print_r($_SESSION, true));

            ob_start(); // Démarre un buffer de sortie
            redirect(match($user['role']) {
                'admin' => '/dashboard',
                'apprenant' => '/apprenant/dashboard',
                'vigile' => '/vigile/scan',
            });
            exit;
        } catch (Exception $e) {
            error_log("Erreur d'authentification: " . $e->getMessage());
            $errorKey = $e->getMessage();
            
            $errors = require __DIR__ . '/error.controller.php';
            session_set('login_errors', [$errors[$errorKey] ?? 'Une erreur est survenue']);
            session_set('old_input', [
                'login' => $login
            ]);
        }
    }

    require __DIR__ . '/../Views/auth/login.php';

    if (session_has('login_errors')) {
        session_remove('login_errors');
    }
}

function logout() {
    session_destroy_all();
    redirect('/');
}

function forgotPassword() {
    session_init();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $login = trim($_POST['login'] ?? '');
            $newPassword = trim($_POST['new_password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');

            if (empty($login) || empty($newPassword) || empty($confirmPassword)) {
                throw new Exception('required_field');
            }

            if ($newPassword !== $confirmPassword) {
                throw new Exception('password_mismatch');
            }

            $userModel = require __DIR__ . '/../Models/User.model.php';
            $user = findUserByLogin($login);
            if (!$user) {
                throw new Exception('user_not_found');
            }

            // ⚠️ À adapter : logique de mise à jour du mot de passe
            $success = true;

            if (!$success) {
                throw new Exception('update_failed');
            }

            session_set('login_success', 'Mot de passe mis à jour avec succès');
            redirect('/');
        } catch (Exception $e) {
            session_set('forgot_password_errors', [$e->getMessage()]);
            session_set('old_input', ['login' => $login ?? '']);
        }
    }

    require __DIR__ . '/../Views/auth/forgot_password.php';
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
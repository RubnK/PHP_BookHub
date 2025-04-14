<?php
namespace App\Controllers;

class AuthController {
    public function login() {
        $title = 'Connexion | BookHub';
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/auth/login.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function register() {
        $title = 'Inscription | BookHub';
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/auth/register.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }

    public function doLogin() {
        // Traitement du login ici (à implémenter)
        echo "TODO: traitement login";
    }

    public function doRegister() {
        // Traitement de l'inscription ici (à implémenter)
        echo "TODO: traitement inscription";
    }
}

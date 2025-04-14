<?php
namespace App\Controllers;
use App\Models\User;

class AuthController {
    public function login() {
        $title = 'Connexion | BookHub';
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/login.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function register() {
        $title = 'Inscription | BookHub';
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/register.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }

    public function doLogin() {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
    
        $user = \App\Models\User::findByEmail($email);
    
        if (!$user || !password_verify($password, $user['password'])) {
            echo "Identifiants invalides.";
            return;
        }
    
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email']
        ];
    
        header('Location: /books');
        exit;
    }
    


    public function doRegister() {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm'] ?? '';

        if (!$username || !$email || !$password || $password !== $confirm) {
            echo "Tous les champs sont obligatoires et les mots de passe doivent correspondre.";
            return;
        }

        if (User::findByEmail($email)) {
            echo "Un compte existe déjà avec cet email.";
            return;
        }

        User::create($username, $email, $password);

        header('Location: /login');
        exit;
    }
}

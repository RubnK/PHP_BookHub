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
    
        $user = User::findByEmail($email);
    
        if (!$user || !password_verify($password, $user['password'])) {
            $error = "Identifiants invalides.";
        }
        
        if ($error) {
            $title = 'Connexion | BookHub';
            require_once __DIR__ . '/../Views/includes/header.php';
            require_once __DIR__ . '/../Views/login.php';
            require_once __DIR__ . '/../Views/includes/footer.php';
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
            $error = "Tous les champs sont obligatoires et les mots de passe doivent correspondre.";
        }

        if (User::findByEmail($email)) {
            $error = "Un compte existe déjà avec cet email.";
        }

        if ($error) {
            $title = 'Inscription | BookHub';
            require_once __DIR__ . '/../Views/includes/header.php';
            require_once __DIR__ . '/../Views/register.php';
            require_once __DIR__ . '/../Views/includes/footer.php';
            return;
        }

        User::create($username, $email, $password);

        header('Location: /login');
        exit;
    }
}

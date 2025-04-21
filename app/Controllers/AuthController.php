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
    
        if (!$user || hash('sha256', $password) != $user['password']) {
            $error = "Identifiants invalides.";
        }
        
        if (isset($error) && $error) {
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
    
        header('Location: /');
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

        if (isset($error) && $error) {
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

    public function profil() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    
        $title = 'Mon profil | BookHub';
        $user = $_SESSION['user'];
    
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/profil.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }
    
    public function updateProfil() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    
        $title = 'Mon profil | BookHub';
        $user = $_SESSION['user'];
        $error = $success = null;
    
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
    
        if (!$username || !$email) {
            $error = "Nom et email obligatoires.";
        } elseif (User::emailExists($email, $user['id'])) {
            $error = "Cet email est déjà utilisé.";
        } else {
            User::updateBasic($user['id'], $username, $email);
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email'] = $email;
    
            if ($current && $new && $confirm) {
                if ($new !== $confirm) {
                    $error = "Les mots de passe ne correspondent pas.";
                } elseif (hash('sha256', $current) != User::getHashedPasswordById($user['id'])) {
                    $error = "Mot de passe actuel incorrect.";
                } else {
                    User::updatePassword($user['id'], $new);
                    $success = "Profil et mot de passe mis à jour.";
                }
            } elseif (!$error) {
                $success = "Profil mis à jour.";
            }
        }
    
        require_once __DIR__ . '/../Views/includes/header.php';
        require_once __DIR__ . '/../Views/profil.php';
        require_once __DIR__ . '/../Views/includes/footer.php';
    }

    public function deleteProfil() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    
        $user_id = $_SESSION['user']['id'];
    
        User::delete($user_id);
    
        session_destroy();
    
        header('Location: /');
        exit;
    }

}

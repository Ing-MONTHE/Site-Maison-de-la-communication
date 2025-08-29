<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
    public function showLogin() {
        require __DIR__ . "/../Views/auth/login.php";
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = User::findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: index.php?controller=dashboard&action=home");
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
                require __DIR__ . "/../Views/auth/login.php";
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit;
    }

    public function registerForm() {
        require __DIR__ . "/../Views/auth/register.php";
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email'    => $_POST['email'],
                'password' => $_POST['password'],
                'role'     => 'visiteur_auth'
            ];
            User::create($data);
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
    }
}

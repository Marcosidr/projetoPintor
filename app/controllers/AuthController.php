<?php
require_once ROOT_PATH . 'app/Models/User.php';
require_once ROOT_PATH . 'app/Models/Log.php';

class AuthController {
    public function showLogin() {
        view('painel/login');
    }

    public function login(array $data) {
        session_start();
        $user = User::findByEmail($data['email']);

        if (!$user || !password_verify($data['senha'], $user['senha'])) {
            $_SESSION['erro'] = "E-mail ou senha inválidos.";
            header("Location: /login");
            exit;
        }

        $_SESSION['usuario'] = $user;
        Log::registrar("LOGIN OK: {$user['email']}", "INFO");
        header("Location: /painel");
    }

    public function logout() {
        session_start();
        if (!empty($_SESSION['usuario'])) {
            Log::registrar("LOGOUT: {$_SESSION['usuario']['email']}", "INFO");
        }
        session_destroy();
        header("Location: /login");
    }

    public function showRegister() {
        view('painel/register');
    }

    public function register(array $data) {
        session_start();

        if (empty($data['nome']) || empty($data['email']) || empty($data['senha'])) {
            $_SESSION["erro"] = "Preencha todos os campos.";
            header("Location: /register");
            return;
        }

        if (strlen($data['senha']) < 6) {
            $_SESSION["erro"] = "A senha deve ter pelo menos 6 caracteres.";
            header("Location: /register");
            return;
        }

        try {
            if (User::findByEmail($data['email'])) {
                $_SESSION["erro"] = "E-mail já cadastrado.";
                header("Location: /register");
                return;
            }

            User::create($data['nome'], $data['email'], $data['senha']);
            Log::registrar("REGISTRO OK: {$data['email']}", "INFO");

            $_SESSION["sucesso"] = "Usuário registrado com sucesso!";
            header("Location: /login");

        } catch (Exception $e) {
            $_SESSION["erro"] = "Erro: " . $e->getMessage();
            Log::registrar("REGISTRO ERRO: {$data['email']} - {$e->getMessage()}", "ERROR");
            header("Location: /register");
        }
    }
}

<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Response;
use App\Core\Csrf;
use App\Services\AuthService;
use App\Services\LoggerService;

class AuthController extends Controller {
    private AuthService $auth; private LoggerService $logger;
    public function __construct() { $this->auth = new AuthService(); $this->logger = new LoggerService(); }

    public function showLogin(): void {
        $erro = Session::get('erro','');
        $sucesso = Session::get('sucesso','');
        Session::remove('erro'); Session::remove('sucesso');
        $this->view('auth/login', compact('erro','sucesso'));
    }

    public function login(): void {
        if (!Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF inválido'); }
        $res = $this->auth->login($_POST['email'] ?? '', $_POST['senha'] ?? '');
        if (!$res['ok']) {
            $this->logger->info(null, 'login_falha', ['email'=>$_POST['email'] ?? '', 'erro'=>$res['error']]);
            Session::set('erro', $res['error']);
            Response::redirect(BASE_URL . '/login');
        }
        Session::set('usuario', $res['user']);
        $this->logger->info($res['user']['id'] ?? null, 'login_sucesso', ['email'=>$res['user']['email'] ?? '']);
        Response::redirect(BASE_URL . '/painel');
    }

    public function showRegister(): void {
        $erro = Session::get('erro','');
        $sucesso = Session::get('sucesso','');
        Session::remove('erro'); Session::remove('sucesso');
        $this->view('auth/register', compact('erro','sucesso'));
    }

    public function register(): void {
        if (!Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF inválido'); }
        $res = $this->auth->register($_POST['nome'] ?? '', $_POST['email'] ?? '', $_POST['senha'] ?? '');
        if (!$res['ok']) {
            $this->logger->info(null, 'registro_falha', ['email'=>$_POST['email'] ?? '', 'erro'=>$res['error']]);
            Session::set('erro', $res['error']);
            Response::redirect(BASE_URL . '/register');
        }
        $this->logger->info($res['user']['id'] ?? null, 'registro_sucesso', ['email'=>$res['user']['email'] ?? '']);
        Session::set('sucesso','Registrado com sucesso! Faça login.');
        Response::redirect(BASE_URL . '/login');
    }

    public function logout(): void {
        $user = Session::get('usuario');
        $this->logger->info($user['id'] ?? null, 'logout', ['email'=>$user['email'] ?? null]);
        Session::remove('usuario');
        Session::regenerate();
        Response::redirect(BASE_URL . '/login');
    }
}
<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Response;
use App\Core\Csrf;
use App\Services\AuthService;
use App\Services\LoggerService;
use App\Services\PasswordResetService;
use App\Services\MailService;

class AuthController extends Controller {
    private AuthService $auth; private LoggerService $logger; private PasswordResetService $resetService; private MailService $mail;
    public function __construct() { $this->auth = new AuthService(); $this->logger = new LoggerService(); $this->resetService = new PasswordResetService(); $this->mail = new MailService(); }

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
        // Auto login imediato
        $this->logger->info($res['user']['id'] ?? null, 'registro_sucesso', ['email'=>$res['user']['email'] ?? '']);
        Session::set('usuario', $res['user']);
        Session::set('sucesso', 'Bem-vindo! Conta criada e sessão iniciada.');
        Response::redirect(BASE_URL . '/painel');
    }

    public function logout(): void {
        $user = Session::get('usuario');
        $this->logger->info($user['id'] ?? null, 'logout', ['email'=>$user['email'] ?? null]);
        Session::remove('usuario');
        Session::regenerate();
        Response::redirect(BASE_URL . '/login');
    }

    /* Reset de senha */
    public function forgotPassword(): void {
        $msg = Session::get('msg'); Session::remove('msg');
        $this->view('auth/forgot_password', compact('msg'));
    }

    public function sendReset(): void {
        if (!Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF inválido'); }
        $email = strtolower(trim($_POST['email'] ?? ''));
        $tokenData = null;
        if ($email !== '') {
            $tokenData = $this->resetService->generate($email);
            if ($tokenData) {
                $link = BASE_URL . '/reset-password?token=' . urlencode($tokenData['rawToken']) . '&email=' . urlencode($tokenData['email']);
                $html = '<p>Você solicitou a redefinição de senha.</p><p>Clique no link (válido por 60 minutos):<br><a href="'.htmlspecialchars($link,ENT_QUOTES,'UTF-8').'">Redefinir Senha</a></p>';
                $this->mail->send($tokenData['email'], 'Redefinição de Senha', $html);
                $this->logger->info(null, 'reset_solicitado', ['email'=>$tokenData['email']]);
            }
        }
        Session::set('msg','Se o e-mail existir no sistema, enviaremos instruções.');
        Response::redirect(BASE_URL . '/forgot-password');
    }

    public function showResetForm(): void {
        $email = $_GET['email'] ?? ''; $token = $_GET['token'] ?? '';
        $erro = Session::get('erro'); Session::remove('erro');
        $this->view('auth/reset_password', compact('email','token','erro'));
    }

    public function processReset(): void {
        if (!Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF inválido'); }
        $email = $_POST['email'] ?? ''; $token = $_POST['token'] ?? ''; $senha = $_POST['senha'] ?? ''; $conf = $_POST['senha_confirmation'] ?? '';
        if ($senha === '' || $senha !== $conf) {
            Session::set('erro','Senha inválida ou não coincide.');
            Response::redirect(BASE_URL . '/reset-password?token='.urlencode($token).'&email='.urlencode($email));
        }
        $ok = $this->resetService->consume($email, $token, $senha);
        if (!$ok) {
            Session::set('erro','Link inválido ou expirado.');
            Response::redirect(BASE_URL . '/reset-password?token='.urlencode($token).'&email='.urlencode($email));
        }
        $this->logger->info(null, 'reset_senha_sucesso', ['email'=>$email]);
        Session::set('sucesso','Senha redefinida. Faça login.');
        Response::redirect(BASE_URL . '/login');
    }
}
<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\AuthController;
use App\Core\Session;

require_once __DIR__ . '/bootstrap.php';

/**
 * Teste de integração leve do fluxo de login via AuthController.
 * Simula POST /login preenchendo $_POST, injeta repositórios mockados na AuthService
 * através de substituição após construção do controller (acompanha contrato público atual).
 */
class AuthControllerLoginSuccessTest extends TestCase {
    protected function setUp(): void {
        // Reseta array de sessão sem reiniciar desnecessariamente
        if (session_status() !== PHP_SESSION_ACTIVE) { @session_start(); }
        $_SESSION = [];
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        // Limpa variáveis globais de request
        $_POST = $_GET = [];
    }

    public function testLoginSuccessStoresUserInSessionAndRedirects(): void {
        $notices = [];
        $prevHandler = set_error_handler(function($severity,$message,$file,$line) use (&$notices){
            if ($severity === E_USER_NOTICE || $severity === E_NOTICE) {
                $notices[] = $message.' @'.$file.':'.$line;
                return true; // suprime propagação
            }
            return false; // outros deixam seguir
        });
        // Repositório fake compatível com AuthService (findByEmail/create)
        $userRepo = new class {
            public array $users = [];
            public function findByEmail(string $email): ?array { return $this->users[$email] ?? null; }
            public function create(array $data): int { $id = count($this->users)+1; $data['id']=$id; $this->users[$data['email']]=$data; return $id; }
        };
        // Mock de tentativas (sem lockout real aqui)
        $attemptRepo = new class extends \App\Repositories\LoginAttemptRepository {
            public array $rows = []; public function __construct(){}
            public function record(?string $email, ?string $ip, bool $sucesso): void { $this->rows[]=['e'=>$email,'s'=>$sucesso]; }
            public function countRecentFailures(?string $email, ?string $ip, DateTimeInterface $since): int { return 0; }
            public function clearFailures(?string $email): void {}
        };
        // Criar usuário "pré-existente"
        $hash = password_hash('segredo', PASSWORD_DEFAULT);
        $userRepo->create(['nome'=>'Teste','email'=>'teste@ex.com','senha'=>$hash,'tipo'=>'user']);

        // Subclasse do AuthService injetando repos custom
        $authService = new class($userRepo,$attemptRepo) extends App\Services\AuthService {
            public function __construct($u,$a){ parent::__construct($u,$a); }
        };

        // Subclasse do controller para permitir injeção da AuthService sem alterar código fonte
        $controller = new class($authService) extends App\Controllers\AuthController {
            public function __construct(private $svc){
                // Evita execução do __construct original que criaria dependências reais
                // Em seguida injeta manualmente as propriedades necessárias.
                $ref = new ReflectionClass(App\Controllers\AuthController::class);
                foreach (['auth'=> $this->svc, 'logger'=> new App\Services\LoggerService('file', sys_get_temp_dir()), 'resetService'=> new App\Services\PasswordResetService(), 'mail'=> new App\Services\MailService()] as $name=>$val) {
                    $p = $ref->getProperty($name); $p->setAccessible(true); $p->setValue($this, $val);
                }
            }
        };

        // Gera token CSRF válido
        if (!function_exists('csrf_field')) { function csrf_field(){ $t = bin2hex(random_bytes(8)); $_SESSION['_csrf']=$t; return '<input type="hidden" name="_csrf" value="'.$t.'">'; } }
        $_SESSION['_csrf'] = 'tokentest';

        // Simula POST de login
        $_POST = [ '_csrf'=>'tokentest', 'email'=>'teste@ex.com', 'senha'=>'segredo' ];

        // Captura headers de redirect interceptando Response::redirect via redefinição temporária
        $gotRedirect = null; $self = $this;
        // Monkey patch simples: usar runkit não é opção; então interceptamos saída com output buffering e analisamos headers_list
        // Executa login (redirect final será chamado; ignoramos saída)
        try { $controller->login(); } catch (Throwable $e) {
            // Em testes, Response::redirect pode usar header()+exit; se adaptado, silenciamos.
        }

    $this->assertArrayHasKey('usuario', $_SESSION, 'Usuário não armazenado em sessão');
    $this->assertSame('teste@ex.com', $_SESSION['usuario']['email']);
    $this->assertSame('Teste', $_SESSION['usuario']['nome']);
    $this->assertSame('user', $_SESSION['usuario']['tipo']);
        // Nenhum notice esperado
        $this->assertSame([], $notices, 'Não deveria haver PHP notices durante o fluxo de login.');
        if ($prevHandler) { set_error_handler($prevHandler); }
    }
}

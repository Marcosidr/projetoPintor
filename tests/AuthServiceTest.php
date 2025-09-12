<?php
use PHPUnit\Framework\TestCase;
use App\Services\AuthService;

class AuthServiceTest extends TestCase {
    private $repo; // mock repository
    private AuthService $service; private $attempts;
    protected function setUp(): void {
        // Mock simples do repository via classe anônima compatível com AuthService
        $this->repo = new class {
            public array $users = [];
            public function findByEmail(string $email): ?array { return $this->users[$email] ?? null; }
            public function create(array $data): int { $id = count($this->users)+1; $data['id']=$id; $this->users[$data['email']]=$data; return $id; }
        };
        // Usa closure para injetar uma instância adaptada (AuthService aceita UsuarioRepository ou similar com mesmos métodos)
        $this->attempts = new class extends \App\Repositories\LoginAttemptRepository {
            public array $rows = [];
            public function __construct(){}
            public function record(?string $email, ?string $ip, bool $sucesso): void { $this->rows[] = ['e'=>$email,'ip'=>$ip,'s'=>$sucesso,'t'=>time()]; }
            public function countRecentFailures(?string $email, ?string $ip, DateTimeInterface $since): int {
                $c=0; $min = $since->getTimestamp();
                foreach($this->rows as $r){ if(!$r['s'] && $r['t'] >= $min && ($email===null || $r['e']===$email)) $c++; }
                return $c;
            }
            public function clearFailures(?string $email): void { if($email===null) return; $this->rows = array_filter($this->rows, fn($r)=>$r['e']!==$email); }
        };
        $this->service = new AuthService($this->repo, $this->attempts);
    }

    public function testRegisterSuccess(): void {
        $res = $this->service->register('Nome','email@ex.com','segredo');
        $this->assertTrue($res['ok']);
        $this->assertSame(1, $res['id']);
    }

    public function testRegisterDuplicateEmail(): void {
        $this->service->register('Nome','dup@ex.com','segredo');
        $res = $this->service->register('Outro','dup@ex.com','segredo');
        $this->assertFalse($res['ok']);
        $this->assertEquals('E-mail já registrado.', $res['error']);
    }

    public function testLoginSuccess(): void {
        $this->service->register('Nome','login@ex.com','segredo');
        // Ajusta senha já vem hash pela service
        $res = $this->service->login('login@ex.com','segredo');
        $this->assertTrue($res['ok']);
        $this->assertEquals('login@ex.com',$res['user']['email']);
    }

    public function testLoginFail(): void {
        $res = $this->service->login('nao@ex.com','xxx');
        $this->assertFalse($res['ok']);
        $this->assertEquals('Credenciais inválidas.', $res['error']);
    }
}

<?php
use PHPUnit\Framework\TestCase;
use App\Services\AuthService;
use App\Repositories\UsuarioRepository;
use App\Repositories\LoginAttemptRepository;

class AuthServiceLockoutTest extends TestCase {
    private PDO $pdo; private AuthService $auth;

    protected function setUp(): void {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('CREATE TABLE usuarios (id INTEGER PRIMARY KEY AUTOINCREMENT, nome TEXT, email TEXT UNIQUE, senha TEXT, tipo TEXT, criado_em TEXT)');
        $this->pdo->exec('CREATE TABLE login_attempts (id INTEGER PRIMARY KEY AUTOINCREMENT, email TEXT NULL, ip TEXT NULL, sucesso INTEGER NOT NULL, created_at TEXT NOT NULL)');
        // repos custom
        $userRepo = new class($this->pdo) extends UsuarioRepository {
            public function __construct(private PDO $pdo){}
            public function findByEmail(string $email): ?array { $st=$this->pdo->prepare('SELECT * FROM usuarios WHERE email=?'); $st->execute([$email]); $r=$st->fetch(PDO::FETCH_ASSOC); return $r?:null; }
            public function create(array $data): int { $st=$this->pdo->prepare('INSERT INTO usuarios (nome,email,senha,tipo) VALUES (?,?,?,?)'); $st->execute([$data['nome'],$data['email'],$data['senha'],$data['tipo']??'user']); return (int)$this->pdo->lastInsertId(); }
            public function update(int $id, array $data): bool { $fields=[];$params=[]; foreach($data as $k=>$v){$fields[]="$k=?";$params[]=$v;} $params[]=$id; $sql='UPDATE usuarios SET '.implode(',', $fields).' WHERE id=?'; return $this->pdo->prepare($sql)->execute($params);}        
        };
        $attemptRepo = new class($this->pdo) extends LoginAttemptRepository {
            public function __construct(private PDO $pdo){}
            public function record(?string $email, ?string $ip, bool $sucesso): void { $ts = date('Y-m-d H:i:s'); $this->pdo->prepare('INSERT INTO login_attempts (email, ip, sucesso, created_at) VALUES (?,?,?,?)')->execute([$email,$ip,$sucesso?1:0,$ts]); }
            public function countRecentFailures(?string $email, ?string $ip, DateTimeInterface $since): int {
                $conds = ['sucesso=0','created_at >= :s']; $params=['s'=>$since->format('Y-m-d H:i:s')];
                if ($email) { $conds[] = 'email = :e'; $params['e']=$email; }
                if ($ip) { $conds[] = 'ip = :ip'; $params['ip']=$ip; }
                $sql = 'SELECT COUNT(*) FROM login_attempts WHERE '.implode(' AND ', $conds);
                $st = $this->pdo->prepare($sql); $st->execute($params); return (int)$st->fetchColumn();
            }
            public function clearFailures(?string $email): void { if(!$email)return; $this->pdo->prepare('DELETE FROM login_attempts WHERE email=?')->execute([$email]); }
        };
        $this->auth = new AuthService($userRepo, $attemptRepo);
        $userRepo->create(['nome'=>'Lock','email'=>'lock@example.com','senha'=>password_hash('senhaBoa', PASSWORD_DEFAULT),'tipo'=>'user']);
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    }

    public function testLockoutAfterFiveFailures(): void {
        for($i=1;$i<=5;$i++) {
            $r = $this->auth->login('lock@example.com','errada');
            $this->assertFalse($r['ok']);
        }
        // 6a tentativa deve bloquear (independente da senha)
        $r6 = $this->auth->login('lock@example.com','errada');
        $this->assertFalse($r6['ok']);
        $this->assertStringContainsString('Muitas tentativas', $r6['error']);
    }

    public function testSuccessClearsFailures(): void {
        $this->auth->login('lock@example.com','errada');
        $this->auth->login('lock@example.com','errada');
        $r = $this->auth->login('lock@example.com','senhaBoa');
        $this->assertTrue($r['ok']);
        // próxima falha reinicia contagem
        $falha = $this->auth->login('lock@example.com','errada');
        $this->assertFalse($falha['ok']);
    }
}

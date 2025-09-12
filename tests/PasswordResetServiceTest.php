<?php
use PHPUnit\Framework\TestCase;
use App\Services\PasswordResetService;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UsuarioRepository;

class PasswordResetServiceTest extends TestCase {
    private PDO $pdo; private PasswordResetService $service;

    protected function setUp(): void {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('CREATE TABLE usuarios (id INTEGER PRIMARY KEY AUTOINCREMENT, nome TEXT, email TEXT UNIQUE, senha TEXT, tipo TEXT, criado_em TEXT)');
        $this->pdo->exec('CREATE TABLE password_resets (id INTEGER PRIMARY KEY AUTOINCREMENT, email TEXT, token_hash TEXT, created_at TEXT, expires_at TEXT, used_at TEXT NULL, ip TEXT NULL, user_agent TEXT NULL)');
        // Repositórios custom simples
        $userRepo = new class($this->pdo) extends UsuarioRepository {
            public function __construct(private PDO $pdo){}
            public function findByEmail(string $email): ?array { $st=$this->pdo->prepare('SELECT * FROM usuarios WHERE email=?'); $st->execute([$email]); $r=$st->fetch(PDO::FETCH_ASSOC); return $r?:null; }
            public function update(int $id, array $data): bool { $fields=[];$params=[]; foreach($data as $k=>$v){$fields[]="$k=?";$params[]=$v;} $params[]=$id; $sql='UPDATE usuarios SET '.implode(',', $fields).' WHERE id=?'; return $this->pdo->prepare($sql)->execute($params);}        
            public function create(array $data): int { $st=$this->pdo->prepare('INSERT INTO usuarios (nome,email,senha,tipo) VALUES (?,?,?,?)'); $st->execute([$data['nome'],$data['email'],$data['senha'],$data['tipo']??'user']); return (int)$this->pdo->lastInsertId(); }
        };
        $resetRepo = new class($this->pdo) extends PasswordResetRepository {
            public function __construct(private PDO $pdo){}
            public function invalidatePrevious(string $email): void { $this->pdo->prepare('UPDATE password_resets SET used_at=datetime("now") WHERE email=? AND used_at IS NULL')->execute([$email]); }
            public function create(string $email, string $tokenHash, DateTimeInterface $expiresAt, ?string $ip, ?string $ua): int { $st=$this->pdo->prepare('INSERT INTO password_resets (email, token_hash, created_at, expires_at, ip, user_agent) VALUES (?,?,?,?,?,?)'); $st->execute([$email,$tokenHash,date('Y-m-d H:i:s'),$expiresAt->format('Y-m-d H:i:s'),$ip,$ua]); return (int)$this->pdo->lastInsertId(); }
            public function findValid(string $email, string $tokenHash, DateTimeInterface $now): ?array { $st=$this->pdo->prepare('SELECT * FROM password_resets WHERE email=? AND token_hash=? AND used_at IS NULL AND expires_at > ? LIMIT 1'); $st->execute([$email,$tokenHash,$now->format('Y-m-d H:i:s')]); $r=$st->fetch(PDO::FETCH_ASSOC); return $r?:null; }
            public function markUsed(int $id): void { $this->pdo->prepare('UPDATE password_resets SET used_at=datetime("now") WHERE id=?')->execute([$id]); }
        };
        $this->service = new PasswordResetService($resetRepo, $userRepo);
        // cria usuário
        $userRepo->create(['nome'=>'Teste','email'=>'user@example.com','senha'=>password_hash('abc123', PASSWORD_DEFAULT),'tipo'=>'user']);
    }

    public function testGenerateCreatesValidToken(): void {
        $data = $this->service->generate('user@example.com', 30);
        $this->assertNotNull($data);
        $this->assertArrayHasKey('rawToken', $data);
        $this->assertMatchesRegularExpression('/^[a-f0-9]{64}$/', $data['rawToken']);
    }

    public function testValidateRejectsInvalid(): void {
        $this->assertNull($this->service->validate('user@example.com','deadbeef'));
    }

    public function testConsumeChangesPassword(): void {
        $gen = $this->service->generate('user@example.com',30);
        $ok = $this->service->consume('user@example.com', $gen['rawToken'], 'novaSenhaSegura');
        $this->assertTrue($ok);
        // Validar que outro consumo falha
        $ok2 = $this->service->consume('user@example.com', $gen['rawToken'], 'outra');
        $this->assertFalse($ok2);
    }
}

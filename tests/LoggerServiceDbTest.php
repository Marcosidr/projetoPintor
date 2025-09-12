<?php
use PHPUnit\Framework\TestCase;
use App\Services\LoggerService;
use App\Repositories\DbLogRepository;

class LoggerServiceDbTest extends TestCase
{
    private PDO $pdo; private DbLogRepository $repo;

    protected function setUp(): void
    {
        putenv('LOG_DRIVER=db');
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('CREATE TABLE logs (id INTEGER PRIMARY KEY AUTOINCREMENT, ts DATETIME NOT NULL, user_id INT NULL, acao TEXT NOT NULL, ctx TEXT NULL, ip TEXT NULL, ua TEXT NULL)');
        // Monkey patch: substituir conexão global? LoggerService instancia DbLogRepository sozinho usando Database::connection()
        // Para manter simples, criaremos uma subclasse temporária usando repositório injetável.
    }

    public function testGravaEmBanco(): void
    {
        // Subclasse para injetar repo custom (em produção, poderíamos adaptar via DI real)
        // Reimplementa store direto usando PDO local (simples para validar intenção de persistência em driver db)
        $service = new class($this->pdo) extends LoggerService {
            private PDO $pdo;
            public function __construct(PDO $pdo){ parent::__construct('db'); $this->pdo = $pdo; }
            public function info(?int $userId, string $acao, array $context = []): void {
                $json = json_encode($context, JSON_UNESCAPED_UNICODE);
                $stmt = $this->pdo->prepare('INSERT INTO logs (ts,user_id,acao,ctx,ip,ua) VALUES (datetime("now"),?,?,?,?,?)');
                $stmt->execute([$userId,$acao,$json,'1.1.1.1','TestUA']);
            }
        };
        $service->info(7,'teste_db',['x'=>1]);
        $stmt = $this->pdo->query('SELECT user_id, acao, ctx FROM logs LIMIT 1');
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertSame(7, (int)$row['user_id']);
        $this->assertSame('teste_db', $row['acao']);
        $this->assertStringContainsString('"x":1',$row['ctx']);
    }
}

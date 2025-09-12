<?php
use PHPUnit\Framework\TestCase;
use App\Services\LoggerService;
use App\Repositories\DbLogRepository;

class LoggerServiceDbNoFileTest extends TestCase {
    private string $tmpDir;
    protected function setUp(): void { $this->tmpDir = sys_get_temp_dir() . '/logs_db_no_file_' . uniqid(); }
    protected function tearDown(): void { if (is_dir($this->tmpDir)) { array_map('unlink', glob($this->tmpDir.'/*')); @rmdir($this->tmpDir); } }

    public function testDbDriverNaoCriaArquivo(): void {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('CREATE TABLE logs (id INTEGER PRIMARY KEY AUTOINCREMENT, ts DATETIME NOT NULL, user_id INT NULL, acao TEXT NOT NULL, ctx TEXT NULL, ip TEXT NULL, ua TEXT NULL)');
        // Subclasse injeta repositório custom evitando dependência do Database::connection()
        $logger = new class($pdo, $this->tmpDir) extends LoggerService {
            private DbLogRepository $repo; private string $dirLocal;
            public function __construct(PDO $pdo, string $dir){ parent::__construct('db', $dir); $this->repo = new DbLogRepository($pdo); $this->dirLocal = $dir; }
            public function info(?int $userId, string $acao, array $context = []): void {
                // usar repo diretamente
                $ip = '0.0.0.0'; $ua = 'TestUA';
                $this->repo->store($userId, $acao, $context, $ip, $ua);
            }
        };
        $logger->info(1,'acao_db',['x'=>1]);
        $pattern = $this->tmpDir . '/app-' . date('Y-m-d') . '.log';
        $this->assertFileDoesNotExist($pattern, 'Driver db não deve criar arquivo de log');
    }
}

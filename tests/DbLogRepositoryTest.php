<?php
use PHPUnit\Framework\TestCase;
use App\Repositories\DbLogRepository;

class DbLogRepositoryTest extends TestCase
{
    private PDO $pdo; private DbLogRepository $repo;
    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('CREATE TABLE logs (id INTEGER PRIMARY KEY AUTOINCREMENT, ts DATETIME NOT NULL, user_id INT NULL, acao TEXT NOT NULL, ctx TEXT NULL, ip TEXT NULL, ua TEXT NULL)');
        $this->repo = new DbLogRepository($this->pdo);
    }

    public function testStoreAndPaginate(): void
    {
        // Insere 35 entradas
        for ($i=1;$i<=35;$i++) {
            $this->repo->store($i%3===0?null:$i, 'acao_'.$i, ['i'=>$i], '127.0.0.1', 'UA');
        }
        $page1 = $this->repo->paginate([], 1, 20);
        $this->assertSame(35, $page1['total']);
        $this->assertCount(20, $page1['data']);
        $page2 = $this->repo->paginate([], 2, 20);
        $this->assertCount(15, $page2['data']);
    }

    public function testFilterByAcao(): void
    {
        $this->repo->store(1, 'login_sucesso', [], 'ip','ua');
        $this->repo->store(1, 'login_falha', [], 'ip','ua');
        $res = $this->repo->paginate(['acao'=>'sucesso'],1,10);
        $this->assertSame(1, $res['total']);
        $this->assertSame('login_sucesso', $res['data'][0]['acao']);
    }
}

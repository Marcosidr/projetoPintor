<?php
use PHPUnit\Framework\TestCase;
use App\Repositories\CatalogoRepository;

class CatalogoRepositoryTest extends TestCase
{
    private PDO $pdo;
    private CatalogoRepository $repo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('CREATE TABLE catalogos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            titulo TEXT NOT NULL,
            arquivo TEXT NOT NULL,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        )');
        $this->repo = new CatalogoRepository($this->pdo);
    }

    public function testCreateAndAll(): void
    {
        $id1 = $this->repo->create(['titulo' => 'Cat 1', 'arquivo' => 'a.pdf']);
        $id2 = $this->repo->create(['titulo' => 'Cat 2', 'arquivo' => 'b.pdf']);
        $this->assertGreaterThan(0, $id1);
        $this->assertGreaterThan($id1, $id2);
        $all = $this->repo->all();
        $this->assertCount(2, $all);
    }

    public function testFind(): void
    {
        $id = $this->repo->create(['titulo' => 'X', 'arquivo' => 'x.pdf']);
        $row = $this->repo->find($id);
        $this->assertNotNull($row);
        $this->assertSame('X', $row['titulo']);
    }

    public function testDelete(): void
    {
        $id = $this->repo->create(['titulo' => 'Temp', 'arquivo' => 't.pdf']);
        $ok = $this->repo->delete($id);
        $this->assertTrue($ok);
        $this->assertNull($this->repo->find($id));
    }
}

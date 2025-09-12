<?php

use PHPUnit\Framework\TestCase;
use App\Repositories\ServicoRepository;

class ServicoRepositoryTest extends TestCase
{
    private PDO $pdo;
    private ServicoRepository $repo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Criar tabela mínima compatível
        $this->pdo->exec('CREATE TABLE servicos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            icone TEXT NOT NULL,
            titulo TEXT NOT NULL,
            descricao TEXT NOT NULL,
            caracteristicas TEXT NULL,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP,
            updated_at TEXT NULL
        )');
        $this->repo = new ServicoRepository($this->pdo);
    }

    public function testCreateAndFind(): void
    {
        $id = $this->repo->create([
            'icone' => 'bi bi-test',
            'titulo' => 'Servico X',
            'descricao' => 'Desc X',
            'caracteristicas' => ['A', 'B']
        ]);
        $this->assertGreaterThan(0, $id);
        $found = $this->repo->find($id);
        $this->assertNotNull($found);
        $this->assertSame('Servico X', $found['titulo']);
        $this->assertSame(['A','B'], $found['caracteristicas']);
    }

    public function testUpdate(): void
    {
        $id = $this->repo->create([
            'icone' => 'bi bi-test',
            'titulo' => 'Original',
            'descricao' => 'Desc',
            'caracteristicas' => ['A']
        ]);
        $ok = $this->repo->update($id, [
            'icone' => 'bi bi-new',
            'titulo' => 'Alterado',
            'descricao' => 'Nova',
            'caracteristicas' => ['X','Y']
        ]);
        $this->assertTrue($ok);
        $found = $this->repo->find($id);
        $this->assertSame('Alterado', $found['titulo']);
        $this->assertSame(['X','Y'], $found['caracteristicas']);
    }

    public function testDelete(): void
    {
        $id = $this->repo->create([
            'icone' => 'bi bi-trash',
            'titulo' => 'Apagar',
            'descricao' => 'Temp',
            'caracteristicas' => []
        ]);
        $ok = $this->repo->delete($id);
        $this->assertTrue($ok);
        $this->assertNull($this->repo->find($id));
    }

    public function testAllReturnsDecodedArrays(): void
    {
        $this->repo->create([
            'icone' => 'i1', 'titulo' => 'S1', 'descricao' => 'D1', 'caracteristicas' => ['a']
        ]);
        $this->repo->create([
            'icone' => 'i2', 'titulo' => 'S2', 'descricao' => 'D2', 'caracteristicas' => ['b','c']
        ]);
        $all = $this->repo->all();
        $this->assertCount(2, $all);
        $this->assertIsArray($all[0]['caracteristicas']);
    }
}

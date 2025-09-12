<?php
use PHPUnit\Framework\TestCase;
use App\Services\OrcamentoService;

class OrcamentoServiceTest extends TestCase {
    private $repo; // mock repository
    private OrcamentoService $service;
    protected function setUp(): void {
        $this->repo = new class {
            public array $rows = [];
            public function create(array $data): int { $id = count($this->rows)+1; $this->rows[$id]=$data+['id'=>$id]; return $id; }
        };
        $this->service = new OrcamentoService($this->repo);
    }

    public function testCriarSucesso(): void {
        $res = $this->service->criar([
            'nome'=>'Cliente','email'=>'cli@ex.com','telefone'=>'111','servico'=>'Pintura','mensagem'=>'Oi'
        ]);
        $this->assertTrue($res['ok']);
        $this->assertSame(1, $res['id']);
    }

    public function testCriarCamposObrigatorios(): void {
        $res = $this->service->criar([]);
        $this->assertFalse($res['ok']);
        $this->assertEquals('Preencha os campos obrigatórios.', $res['error']);
    }
}

<?php
use PHPUnit\Framework\TestCase;
use App\Services\LoggerService;

class LoggerServiceTest extends TestCase {
    private string $tmpDir;
    protected function setUp(): void { $this->tmpDir = sys_get_temp_dir() . '/logs_test_' . uniqid(); }
    protected function tearDown(): void { if (is_dir($this->tmpDir)) { array_map('unlink', glob($this->tmpDir.'/*')); @rmdir($this->tmpDir); } }

    public function testEscreveLinha(): void {
        // Garante que não estamos forçando driver db via env
        putenv('LOG_DRIVER=file');
        $logger = new LoggerService($this->tmpDir); // retrocompat: primeiro arg tratado como diretório
        $logger->info(5,'acao_teste',['k'=>'v']);
        $file = $this->tmpDir . '/app-' . date('Y-m-d') . '.log';
        $this->assertFileExists($file);
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $this->assertCount(1,$lines);
        $decoded = json_decode($lines[0], true);
        $this->assertEquals(5,$decoded['user']);
        $this->assertEquals('acao_teste',$decoded['acao']);
        $this->assertEquals(['k'=>'v'],$decoded['ctx']);
    }
}

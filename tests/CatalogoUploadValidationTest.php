<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\CatalogoAdminController;

class CatalogoUploadValidationTest extends TestCase
{
    protected function setUp(): void
    {
        $_SESSION = [];
    }

    private function controller(): CatalogoAdminController
    {
        return new class extends CatalogoAdminController {
            // Sobrescreve redirect para teste (não enviar header / exit)
            protected function redirect(string $to): void {
                $_SESSION['__redirect_to'] = $to;
            }
        };
    }

    public function testRejectsInvalidExtension(): void
    {
        $_POST['titulo'] = 'Catalogo Teste';
        $_FILES['arquivo'] = [
            'name' => 'malicioso.exe',
            'type' => 'application/octet-stream',
            'tmp_name' => __FILE__,
            'error' => UPLOAD_ERR_OK,
            'size' => 1234,
        ];
        $c = $this->controller();
        $c->store();
        $this->assertSame('Extensão não permitida', $_SESSION['flash_error'] ?? null);
    }

    public function testRejectsTooLarge(): void
    {
        $_POST['titulo'] = 'Catalogo Grande';
        $_FILES['arquivo'] = [
            'name' => 'arquivo.pdf',
            'type' => 'application/pdf',
            'tmp_name' => __FILE__,
            'error' => UPLOAD_ERR_OK,
            'size' => 6 * 1024 * 1024, // 6MB
        ];
        $c = $this->controller();
        $c->store();
        $this->assertSame('Arquivo muito grande', $_SESSION['flash_error'] ?? null);
    }
}

<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\AdminUserApiController;
use App\Repositories\UsuarioRepository;
use App\Core\Session;
use App\Core\Csrf;

require_once __DIR__.'/bootstrap.php';

class AdminUserApiControllerTest extends TestCase {
    private AdminUserApiController $controller;
    private UsuarioRepository $repo;

    protected function setUp(): void {
        $this->repo = new UsuarioRepository();
        $this->controller = new AdminUserApiController($this->repo);
        // Simula login admin
        Session::set('usuario', ['id'=>1,'tipo'=>'admin','nome'=>'Admin']);
    }

    private function capture(callable $fn): array {
        ob_start(); $fn(); $out = ob_get_clean();
        $json = json_decode($out,true); return [$out,$json];
    }

    public function testListUsersSuccess(): void {
        [$raw,$json] = $this->capture(fn()=> $this->controller->index());
        $this->assertIsArray($json);
        $this->assertTrue($json['success']);
        $this->assertArrayHasKey('data',$json);
    }

    public function testCreateInvalidShortPassword(): void {
        $_POST = [
            '_csrf'=> Csrf::token(),
            'nome'=>'Teste API',
            'email'=>'teste_api@example.com',
            'senha'=>'123',
            'tipo'=>'user'
        ];
        [$raw,$json] = $this->capture(fn()=> $this->controller->store());
        $this->assertFalse($json['success']);
        $this->assertContains('Senha mínima 6 caracteres',$json['errors']);
    }

    public function testCreateAndUpdateFlow(): void {
        $email = 'api_flow_'.uniqid().'@example.com';
        // Create válido
        $_POST = [
            '_csrf'=> Csrf::token(),
            'nome'=>'Usuario Flow',
            'email'=>$email,
            'senha'=>'abcdef',
            'tipo'=>'user'
        ];
        [$raw,$json] = $this->capture(fn()=> $this->controller->store());
        $this->assertTrue($json['success']);
        $id = $json['data']['id'] ?? null;
        $this->assertNotNull($id);
        // Update para admin
        $_POST = [ '_csrf'=> Csrf::token(), 'tipo'=>'admin' ];
        [$raw2,$json2] = $this->capture(fn()=> $this->controller->update($id));
        $this->assertTrue($json2['success']);
        $this->assertEquals('admin',$json2['data']['tipo']);
        // Toggle admin volta para user
        $_POST = ['_csrf'=> Csrf::token()];
        [$raw3,$json3] = $this->capture(fn()=> $this->controller->toggleAdmin($id));
        $this->assertTrue($json3['success']);
        // Reset senha
        $_POST = ['_csrf'=> Csrf::token()];
        [$raw4,$json4] = $this->capture(fn()=> $this->controller->resetSenha($id));
        $this->assertTrue($json4['success']);
        // Delete
        $_POST = ['_csrf'=> Csrf::token()];
        [$raw5,$json5] = $this->capture(fn()=> $this->controller->destroy($id));
        $this->assertTrue($json5['success']);
    }
}

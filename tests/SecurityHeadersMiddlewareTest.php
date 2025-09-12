<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/bootstrap.php';

class SecurityHeadersMiddlewareTest extends TestCase {
    /** @runInSeparateProcess */
    public function testHeadersAreSent() {
        // Isola cabeçalhos enviados nessa execução
        $middleware = new \App\Middleware\SecurityHeadersMiddleware();
        $result = $middleware->handle();
        $this->assertTrue($result);

        $headers = function_exists('headers_list') ? headers_list() : [];

        $this->assertNotEmpty($headers, 'Nenhum header capturado (executar com Xdebug ou verificar SAPI).');

        $assertions = [
            'X-Frame-Options' => false,
            'X-Content-Type-Options' => false,
            'Referrer-Policy' => false,
            'Content-Security-Policy' => false,
        ];
        foreach ($headers as $h) {
            foreach ($assertions as $needle => $present) {
                if (stripos($h, $needle . ':') === 0) {
                    $assertions[$needle] = true;
                }
            }
        }
        foreach ($assertions as $name => $present) {
            $this->assertTrue($present, "Header {$name} ausente");
        }
    }
}

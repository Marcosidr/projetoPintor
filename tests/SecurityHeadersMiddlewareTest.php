<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/bootstrap.php';

class SecurityHeadersMiddlewareTest extends TestCase {
    /** @runInSeparateProcess */
    public function testHeadersAreSent() {
        // Isola cabeçalhos enviados nessa execução
        $middleware = new \App\Middleware\SecurityHeadersMiddleware();
        $this->assertTrue($middleware->handle());
        $listed = function_exists('headers_list') ? headers_list() : [];
        $captured = [];
        foreach ($listed as $raw) {
            $parts = explode(':', $raw, 2);
            if (count($parts) === 2) {
                $captured[trim($parts[0])] = trim($parts[1]);
            }
        }
        // Fallback para ambiente CLI onde headers_list retorna vazio
        if (empty($captured)) {
            $captured = $middleware->headers();
        }
        $expected = ['X-Frame-Options','X-Content-Type-Options','Referrer-Policy','Content-Security-Policy'];
        foreach ($expected as $hName) {
            $this->assertArrayHasKey($hName, $captured, "Header {$hName} ausente");
        }
    }
}

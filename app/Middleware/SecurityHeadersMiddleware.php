<?php
namespace App\Middleware;

/**
 * Middleware de cabeçalhos de segurança.
 * Centraliza a aplicação dos principais headers para:
 *  - Mitigar clickjacking (X-Frame-Options)
 *  - Evitar sniffing de MIME (X-Content-Type-Options)
 *  - Controlar vazamento de origem de navegação (Referrer-Policy)
 *  - Restringir fontes externas (CSP)
 *  - Forçar HTTPS persistente (HSTS) apenas quando já em HTTPS.
 */
class SecurityHeadersMiddleware {
    /**
     * Retorna array associativo de cabeçalhos de segurança base.
     * Facilita testes em SAPI CLI onde header()/headers_list() não funcionam.
     */
    public function headers(): array {
        $headers = [
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'no-referrer-when-downgrade',
            'Content-Security-Policy' => "default-src 'self' https://cdn.jsdelivr.net; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; img-src 'self' data:; font-src 'self' https://cdn.jsdelivr.net; frame-ancestors 'self'; form-action 'self'",
        ];
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            $headers['Strict-Transport-Security'] = 'max-age=63072000; includeSubDomains; preload';
        }
        return $headers;
    }

    public function handle(): bool {
        foreach ($this->headers() as $name => $value) {
            // Em ambientes CLI (testes) header() é inócuo, mas não causa erro.
            header($name . ': ' . $value);
        }
        return true;
    }
}

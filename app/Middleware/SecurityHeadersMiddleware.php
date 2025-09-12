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
    public function handle(): bool {
        // Impede que outros domínios em iFrames incorporem nossa página (clickjacking).
        header('X-Frame-Options: SAMEORIGIN');
        // Evita que o browser tente adivinhar tipo de arquivo e execute conteúdo indevido.
        header('X-Content-Type-Options: nosniff');
        // Não envia referrer completo quando downgrade (HTTPS -> HTTP). Balanceia privacidade e funcionalidades.
        header("Referrer-Policy: no-referrer-when-downgrade");
        // CSP estrita: tudo default apenas self + CDN jsDelivr; inline liberado só para styles (Bootstrap precisa).
        header("Content-Security-Policy: default-src 'self' https://cdn.jsdelivr.net; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; img-src 'self' data:; font-src 'self' https://cdn.jsdelivr.net; frame-ancestors 'self'; form-action 'self'");
        // HSTS somente se já estamos servindo via HTTPS para não bloquear ambientes locais HTTP.
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            header('Strict-Transport-Security: max-age=63072000; includeSubDomains; preload');
        }
        return true;
    }
}

<?php
namespace App\Core;

// Classe responsável por carregar e acessar variáveis de ambiente
class Env {
    // Cache interno para armazenar as variáveis carregadas
    private static array $cache = [];

    // Carrega variáveis de ambiente de um arquivo .env
    public static function load(string $path): void {
        // Se o arquivo não existir, não faz nada
        if (!is_file($path)) return;
        // Lê o arquivo linha por linha, ignorando linhas vazias
        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            // Ignora comentários (linhas que começam com #)
            if (str_starts_with(trim($line), '#')) continue;
            // Divide a linha em chave e valor usando o sinal de igual (=)
            [$k,$v] = array_pad(explode('=', $line, 2), 2, '');
            $k = trim($k); $v = trim($v);
            // Ignora se a chave estiver vazia
            if ($k==='') continue;
            // Salva no cache interno
            self::$cache[$k] = $v;
            // Adiciona ao array global $_ENV se ainda não existir
            if (!array_key_exists($k, $_ENV)) $_ENV[$k] = $v;
            // Adiciona ao array global $_SERVER se ainda não existir
            if (!array_key_exists($k, $_SERVER)) $_SERVER[$k] = $v;
        }
    }

    // Recupera o valor de uma variável de ambiente
    public static function get(string $key, ?string $default = null): ?string {
        // Procura primeiro no cache, depois em $_ENV, senão retorna o valor padrão
        return self::$cache[$key] ?? $_ENV[$key] ?? $default;
    }
}
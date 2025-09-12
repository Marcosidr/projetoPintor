<?php
namespace App\Core;

/**
 * Router minimalista responsável por:
 *  - Registrar rotas GET/POST com callbacks ou [Controller::class, 'metodo']
 *  - Suportar parâmetros nomeados no caminho: /servicos/{id}
 *  - Executar cadeia de middlewares por rota antes da ação
 *  - Resolver 404 quando nenhuma rota casar
 *
 * Decisões de design:
 *  - Simplicidade: não há grupos, prefixos ou injeção automática — mantido intencionalmente enxuto.
 *  - Regex gerado a partir de placeholders {param} -> (?P<param>[^/]+) para capturar valores nomeados.
 *  - Middlewares podem ser: classe com método handle() ou callable.
 */
class Router {
    /** @var array<string,array<int,array{path:string,pattern:string,action:callable|array,middleware:array}>> */
    private array $routes = ['GET'=>[], 'POST'=>[]];
    // (Reservado para futuro: grupos ou alias de middleware)
    private array $middlewareGroups = [];

    /** Atalho para registrar rota GET */
    public function get(string $path, callable|array $action, array $middleware = []): void { $this->add('GET',$path,$action,$middleware); }
    /** Atalho para registrar rota POST */
    public function post(string $path, callable|array $action, array $middleware = []): void { $this->add('POST',$path,$action,$middleware); }

    /** Registra internamente a rota normalizando caminho e gerando regex */
    private function add(string $method,string $path, callable|array $action, array $middleware): void {
        $norm = $this->norm($path);                 // Normaliza: remove barras duplicadas e garante prefixo '/'
        $pattern = $this->toRegex($norm);           // Converte placeholders em grupos nomeados
        $this->routes[$method][] = [ 'path'=>$norm,'pattern'=>$pattern,'action'=>$action,'middleware'=>$middleware ];
    }

    /** Normaliza um caminho para formato canônico (/foo/bar ou /) */
    private function norm(string $p): string { $p = '/' . trim($p,'/'); return $p === '/' ? '/' : rtrim($p,'/'); }
    /** Transforma /coisa/{id} em regex com grupo nomeado para extração de params */
    private function toRegex(string $path): string { return '#^'.preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#','(?P<$1>[^/]+)',$path).'$#'; }

    /**
     * Faz o roteamento para a rota correspondente:
     * 1. Normaliza URI
     * 2. Tenta casar cada rota registrada do método
     * 3. Extrai parâmetros nomeados
     * 4. Executa middlewares em ordem; qualquer retorno false aborta
     * 5. Invoca ação (callable ou controller/método)
     * 6. Caso nenhuma rota case -> 404
     */
    public function dispatch(string $method, string $uri) {
        $uri = parse_url($uri, PHP_URL_PATH) ?: '/'; // Remove query string
    $uri = $this->norm($uri);
        foreach ($this->routes[$method] as $route) {
            if (preg_match($route['pattern'], $uri, $matches)) {
                // Constrói array apenas com capturas nomeadas
                $params = [];
                foreach ($matches as $k=>$v) if (!is_int($k)) $params[$k]=$v;
                // Executa middlewares da rota
                foreach ($route['middleware'] as $mw) {
                    if (is_string($mw) && class_exists($mw)) {
                        $mwInstance = new $mw();
                        if (method_exists($mwInstance,'handle')) {
                            $res = $mwInstance->handle();
                            if ($res === false) return; // Interrompe se middleware sinalizar bloqueio
                        }
                    } elseif (is_callable($mw)) {
                        $res = $mw(); if ($res === false) return;
                    }
                }
                // Executa ação
                $action = $route['action'];
                if (is_array($action)) { // [Controller::class,'metodo']
                    [$class,$m] = $action; $instance = new $class(); return $instance->$m(...array_values($params));
                }
                return $action(...array_values($params));
            }
        }
        // Nenhuma rota casou -> 404 custom ou fallback simples
        http_response_code(404);
        if (is_file(ROOT_PATH.'app/Views/errors/404.php')) require ROOT_PATH.'app/Views/errors/404.php'; else echo '404';
    }
}

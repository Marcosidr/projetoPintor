<?php
namespace App\Core;

class Router {
    private array $routes = ['GET'=>[], 'POST'=>[]];
    private array $middlewareGroups = [];

    public function get(string $path, callable|array $action, array $middleware = []): void { $this->add('GET',$path,$action,$middleware); }
    public function post(string $path, callable|array $action, array $middleware = []): void { $this->add('POST',$path,$action,$middleware); }

    private function add(string $method,string $path, callable|array $action, array $middleware): void {
        $norm = $this->norm($path);
        $pattern = $this->toRegex($norm);
        $this->routes[$method][] = [ 'path'=>$norm,'pattern'=>$pattern,'action'=>$action,'middleware'=>$middleware ];
    }

    private function norm(string $p): string { $p = '/' . trim($p,'/'); return $p === '/' ? '/' : rtrim($p,'/'); }
    private function toRegex(string $path): string { return '#^'.preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#','(?P<$1>[^/]+)',$path).'$#'; }

    public function dispatch(string $method, string $uri) {
        $uri = parse_url($uri, PHP_URL_PATH) ?: '/';
        $uri = $this->norm($uri);
        foreach ($this->routes[$method] as $route) {
            if (preg_match($route['pattern'], $uri, $matches)) {
                $params = [];
                foreach ($matches as $k=>$v) if (!is_int($k)) $params[$k]=$v;
                // Executa middlewares
                foreach ($route['middleware'] as $mw) {
                    if (is_string($mw) && class_exists($mw)) { $mwInstance = new $mw(); if (method_exists($mwInstance,'handle')) { $res = $mwInstance->handle(); if ($res === false) return; } }
                    elseif (is_callable($mw)) { $res = $mw(); if ($res === false) return; }
                }
                $action = $route['action'];
                if (is_array($action)) {
                    [$class,$m] = $action; $instance = new $class(); return $instance->$m(...array_values($params));
                }
                return $action(...array_values($params));
            }
        }
        http_response_code(404); if (is_file(ROOT_PATH.'app/Views/errors/404.php')) require ROOT_PATH.'app/Views/errors/404.php'; else echo '404';
    }
}

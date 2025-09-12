<?php
namespace App\Services;

use App\Repositories\DbLogRepository;

class LoggerService {
    private string $driver; // file|db
    private string $dir;
    private ?DbLogRepository $repo = null;

    /**
     * @param string|null $driver  'file' | 'db' | (LEGADO) caminho do diretório quando usado o antigo formato new LoggerService($dir)
     * @param string|null $dir     diretório de logs (apenas driver file)
     */
    public function __construct(?string $driver = null, ?string $dir = null) {
        $envDriver = getenv('LOG_DRIVER') ?: 'file';
        // Retrocompat: se primeiro argumento parece um caminho e driver explícito não informado
        if ($driver && !in_array($driver, ['file','db'], true) && $dir === null) {
            $dir = $driver;          // trata como diretório
            $driver = $envDriver;    // usa driver vindo do ambiente (mantendo comportamento antigo => file por padrão)
        }
        $this->driver = $driver ?: $envDriver;
        $this->dir = rtrim($dir ?? (ROOT_PATH . 'storage/logs'), '/');
        if ($this->driver === 'file') {
            if (!is_dir($this->dir)) mkdir($this->dir, 0777, true);
        } else {
            $this->repo = new DbLogRepository();
        }
    }

    public function info(?int $userId, string $acao, array $context = []): void {
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? null;
        if ($this->driver === 'db') {
            $this->repo?->store($userId, $acao, $context, $ip, $ua);
            return;
        }
        // fallback file
        $line = [
            'ts'=>date('c'),
            'user'=>$userId,
            'acao'=>$acao,
            'ctx'=>$context,
            'ip'=>$ip,
            'ua'=>$ua,
        ];
        $file = $this->dir . '/app-' . date('Y-m-d') . '.log';
        file_put_contents($file, json_encode($line, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
    }

    public function getDriver(): string { return $this->driver; }
}

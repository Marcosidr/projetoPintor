<?php
namespace App\Services;

use App\Repositories\DbLogRepository;

class LoggerService {
    private string $driver; // file|db|both
    private string $dir;
    private ?DbLogRepository $repo = null;
    private bool $dbAvailable = false;

    /**
     * @param string|null $driver  'file' | 'db' | (LEGADO) caminho do diretório quando usado o antigo formato new LoggerService($dir)
     * @param string|null $dir     diretório de logs (apenas driver file)
     */
    public function __construct(?string $driver = null, ?string $dir = null) {
        $envDriver = getenv('LOG_DRIVER') ?: null; // agora null permite auto-detecção
        // Retrocompat: se primeiro argumento parece um caminho e driver explícito não informado
        if ($driver && !in_array($driver, ['file','db','both'], true) && $dir === null) {
            $dir = $driver;          // trata como diretório legado
            $driver = $envDriver ?? 'file';
        }
        $this->driver = ($driver ?: ($envDriver ?? 'file'));
        $this->dir = rtrim($dir ?? (ROOT_PATH . 'storage/logs'), '/');

        // Detecta se tabela logs existe para permitir auto-upgrade: se driver= file mas tabela existe, podemos usar 'db' se LOG_FORCE_DB=1
        $forceDb = getenv('LOG_FORCE_DB') === '1';
        try {
            $pdo = \App\Core\Database::connection();
            $hasTable = $pdo->query("SHOW TABLES LIKE 'logs'")->fetchColumn() !== false;
            if ($hasTable) {
                $this->dbAvailable = true;
                if ($forceDb && $this->driver === 'file') {
                    $this->driver = 'db';
                }
            }
        } catch (\Throwable $e) {
            // se não conseguir checar, segue apenas file
        }

        if ($this->driver === 'db' || $this->driver === 'both') {
            try {
                $this->repo = new DbLogRepository();
            } catch (\Throwable $e) {
                // fallback para file se falhar
                $this->driver = 'file';
            }
        }
        if ($this->driver === 'file' || $this->driver === 'both') {
            if (!is_dir($this->dir)) @mkdir($this->dir, 0777, true);
        }
    }

    public function info(?int $userId, string $acao, array $context = []): void {
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $line = [
            'ts'=>date('c'),
            'user'=>$userId,
            'acao'=>$acao,
            'ctx'=>$context,
            'ip'=>$ip,
            'ua'=>$ua,
        ];

        $wroteDb = false;
        if (($this->driver === 'db' || $this->driver === 'both') && $this->repo) {
            try {
                $this->repo->store($userId, $acao, $context, $ip, $ua);
                $wroteDb = true;
            } catch (\Throwable $e) {
                // fallback: anexa info de erro e continua
                $line['db_error'] = substr($e->getMessage(), 0, 200);
            }
        }
        if ($this->driver === 'file' || $this->driver === 'both' || !$wroteDb) {
            $file = $this->dir . '/app-' . date('Y-m-d') . '.log';
            @file_put_contents($file, json_encode($line, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
        }
    }

    public function getDriver(): string { return $this->driver; }
    public function dbIsAvailable(): bool { return $this->dbAvailable; }
}

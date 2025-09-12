<?php
namespace App\Services;

class LoggerService {
    private string $dir;
    public function __construct(string $dir = ROOT_PATH . 'storage/logs') { $this->dir = rtrim($dir,'/'); if (!is_dir($this->dir)) mkdir($this->dir,0777,true); }
    public function info(?int $userId, string $acao, array $context = []): void {
        $line = [
            'ts'=>date('c'),
            'user'=>$userId,
            'acao'=>$acao,
            'ctx'=>$context,
            'ip'=>$_SERVER['REMOTE_ADDR'] ?? null,
            'ua'=>$_SERVER['HTTP_USER_AGENT'] ?? null,
        ];
        $file = $this->dir . '/app-' . date('Y-m-d') . '.log';
        file_put_contents($file, json_encode($line, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
    }
}

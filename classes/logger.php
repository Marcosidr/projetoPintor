<?php
class Logger {
    public static function registrar(string $mensagem, string $arquivo = 'orcamentos.log'): void {
        $logDir = __DIR__ . '/../logs/';
        $file = $logDir . $arquivo;

        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $data = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconhecido';
        $linha = "[$data] [$ip] $mensagem" . PHP_EOL;

        file_put_contents($file, $linha, FILE_APPEND);
    }
}

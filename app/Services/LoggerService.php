<?php
namespace App\Services;

use App\Repositories\DbLogRepository;

/**
 * LoggerService
 *
 * Fornece uma camada unificada de logging com 3 modos:
 *  - file: apenas arquivo (sempre disponível)
 *  - db: apenas banco (requer tabela 'logs')
 *  - both: grava em banco e também no arquivo (redundância / inspeção rápida)
 *
 * Estratégias de robustez:
 *  - Auto-detecção da existência da tabela logs para permitir migração suave.
 *  - Variável de ambiente LOG_FORCE_DB força troca do modo file -> db quando possível.
 *  - Fallback silencioso: se instanciar DbLogRepository falhar, força driver para file.
 *  - Na escrita: se driver incluir db mas o insert falhar, registra no arquivo com campo db_error.
 *  - Compatibilidade retro: construtor ainda aceita (string $dir) no padrão legado.
 */
class LoggerService {
    private string $driver; // file|db|both
    private string $dir;    // diretório para logs de arquivo
    private ?DbLogRepository $repo = null; // instância repositório DB (quando aplicável)
    private bool $dbAvailable = false;    // indica presença de tabela logs para exibição/diagnóstico

    /**
     * @param string|null $driver 'file' | 'db' | 'both' | (LEGADO) caminho do diretório se usado padrão antigo.
     * @param string|null $dir    Diretório de logs quando usando driver file explicitamente.
     */
    public function __construct(?string $driver = null, ?string $dir = null) {
        $envDriver = getenv('LOG_DRIVER') ?: null; // null => deixa configuração cair para 'file' se nada definido.
        // Retrocompatibilidade: se o primeiro argumento não é um driver válido e não há $dir, trata-o como diretório.
        if ($driver && !in_array($driver, ['file','db','both'], true) && $dir === null) {
            $dir = $driver;
            $driver = $envDriver ?? 'file';
        }
        $this->driver = ($driver ?: ($envDriver ?? 'file'));
        $this->dir = rtrim($dir ?? (ROOT_PATH . 'storage/logs'), '/');

        // Descobre se a tabela 'logs' existe para permitir promover file -> db sem quebrar instalações antigas.
        $forceDb = getenv('LOG_FORCE_DB') === '1';
        try {
            $pdo = \App\Core\Database::connection();
            $hasTable = $pdo->query("SHOW TABLES LIKE 'logs'")->fetchColumn() !== false;
            if ($hasTable) {
                $this->dbAvailable = true;
                // Force only se usuário explicitou LOG_FORCE_DB=1 e ainda está em file.
                if ($forceDb && $this->driver === 'file') {
                    $this->driver = 'db';
                }
            }
        } catch (\Throwable $e) {
            // Não impede funcionamento em file, apenas não habilita recursos de DB.
        }

        // Instancia repositório se driver requer DB. Falha => volta para file (continuidade de operação).
        if ($this->driver === 'db' || $this->driver === 'both') {
            try {
                $this->repo = new DbLogRepository();
            } catch (\Throwable $e) {
                $this->driver = 'file';
            }
        }
        // Garante diretório existente para qualquer modo que envolva escrita em arquivo (file ou both, ou fallback).
        if ($this->driver === 'file' || $this->driver === 'both') {
            if (!is_dir($this->dir)) @mkdir($this->dir, 0777, true);
        }
    }

    /**
     * Registra uma linha de log.
     * Fluxo:
     * 1. Monta payload (timestamp ISO8601, user, acao, ctx, ip, ua).
     * 2. Se driver inclui DB: tenta inserir, capturando eventual erro.
     * 3. Escreve em arquivo se driver inclui file OU se escrita DB falhou.
     */
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
                $wroteDb = true; // sucesso => não força arquivo se driver for 'db' puro.
            } catch (\Throwable $e) {
                // Fallback: anexa informação de erro e segue para arquivo.
                $line['db_error'] = substr($e->getMessage(), 0, 200);
            }
        }
        // Escreve em arquivo se modo file|both OU se DB falhou (garante nunca perder log).
        if ($this->driver === 'file' || $this->driver === 'both' || !$wroteDb) {
            $file = $this->dir . '/app-' . date('Y-m-d') . '.log';
            @file_put_contents($file, json_encode($line, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
        }
    }

    /** Driver efetivo após auto-ajustes / fallback. */
    public function getDriver(): string { return $this->driver; }
    /** Indica se a tabela logs foi detectada (útil para telas de diagnóstico). */
    public function dbIsAvailable(): bool { return $this->dbAvailable; }
}

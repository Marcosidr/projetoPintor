<?php
namespace App\Services;

use App\Core\Database;
use PDO;

class DashboardService
{
    private PDO $pdo;
    private string $logTimeCol = 'ts';
    private string $userCreatedCol = 'criado_em';
    private string $orcCreatedCol = 'criado_em';

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::connection();
        $this->initColumns();
    }

    /**
     * Detecta dinamicamente nomes de colunas de data conforme ambiente / migrações.
     * Prioridades: logs: ts > datahora > created_at; usuarios/orcamentos: created_at > criado_em > ts
     */
    private function initColumns(): void {
        $this->logTimeCol      = $this->detectColumn('logs',       ['ts','datahora','created_at'], 'ts');
        $this->userCreatedCol  = $this->detectColumn('usuarios',   ['created_at','criado_em','ts'], 'criado_em');
        $this->orcCreatedCol   = $this->detectColumn('orcamentos', ['created_at','criado_em','ts'], 'criado_em');
    }

    private function detectColumn(string $table, array $candidates, string $fallback): string {
        try {
            $cols = $this->pdo->query("SHOW COLUMNS FROM $table")->fetchAll(PDO::FETCH_COLUMN);
            if (!$cols) return $fallback;
            foreach ($candidates as $c) { if (in_array($c, $cols, true)) return $c; }
        } catch (\Throwable $e) { /* ignora e usa fallback */ }
        return $fallback;
    }

    public function getTotals(): array {
        $totalUsuarios   = (int)$this->pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
        $totalAdmins     = (int)$this->pdo->query("SELECT COUNT(*) FROM usuarios WHERE tipo='admin'")->fetchColumn();
        $totalOrcamentos = (int)$this->pdo->query("SELECT COUNT(*) FROM orcamentos")->fetchColumn();
        $logCol = $this->logTimeCol;
        $stmtLog = $this->pdo->query("SELECT COUNT(*) FROM logs WHERE DATE($logCol)=CURDATE()");
        $totalLogsHoje = (int)($stmtLog?->fetchColumn() ?? 0);
        return compact('totalUsuarios','totalAdmins','totalOrcamentos','totalLogsHoje');
    }

    public function getLogsRecentes(int $limit = 5): array {
        $col = $this->logTimeCol;
        $stmt = $this->pdo->prepare("SELECT $col AS datahora, acao FROM logs ORDER BY $col DESC LIMIT :l");
        $stmt->bindValue(':l', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsuarios(int $limit = 50): array {
        $col = $this->userCreatedCol;
        $stmt = $this->pdo->prepare("SELECT id,nome,email,tipo,$col AS created_at FROM usuarios ORDER BY id DESC LIMIT :l");
        $stmt->bindValue(':l', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGraficoUltimos7Dias(): array {
        $col = $this->orcCreatedCol;
        $dados = [];
        for ($i = 6; $i >= 0; $i--) { $dia = date('Y-m-d', strtotime("-{$i} day")); $dados[$dia] = 0; }
        $stmt = $this->pdo->query("SELECT DATE($col) dia, COUNT(*) total FROM orcamentos WHERE $col >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY dia");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            if (isset($dados[$row['dia']])) { $dados[$row['dia']] = (int)$row['total']; }
        }
        return $dados;
    }
}

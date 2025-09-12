<?php
namespace App\Services;

use App\Core\Database;
use PDO;

class DashboardService
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::connection();
    }

    public function getTotals(): array
    {
        return [
            'totalUsuarios'   => (int)$this->pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn(),
            'totalAdmins'     => (int)$this->pdo->query("SELECT COUNT(*) FROM usuarios WHERE tipo='admin'")->fetchColumn(),
            'totalOrcamentos' => (int)$this->pdo->query("SELECT COUNT(*) FROM orcamentos")->fetchColumn(),
            'totalLogsHoje'   => (int)($this->pdo->query("SELECT COUNT(*) FROM logs WHERE DATE(datahora)=CURDATE()")?->fetchColumn() ?? 0),
        ];
    }

    public function getLogsRecentes(int $limit = 5): array
    {
        $stmt = $this->pdo->prepare("SELECT datahora, acao FROM logs ORDER BY datahora DESC LIMIT :l");
        $stmt->bindValue(':l', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsuarios(int $limit = 50): array
    {
        $stmt = $this->pdo->prepare("SELECT id,nome,email,tipo,created_at FROM usuarios ORDER BY id DESC LIMIT :l");
        $stmt->bindValue(':l', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGraficoUltimos7Dias(): array
    {
        $dados = [];
        for ($i = 6; $i >= 0; $i--) {
            $dia = date('Y-m-d', strtotime("-{$i} day"));
            $dados[$dia] = 0;
        }
        $stmt = $this->pdo->query("SELECT DATE(created_at) dia, COUNT(*) total FROM orcamentos WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY dia");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            if (isset($dados[$row['dia']])) { $dados[$row['dia']] = (int)$row['total']; }
        }
        return $dados;
    }
}

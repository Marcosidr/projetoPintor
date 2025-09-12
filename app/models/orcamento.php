<?php
class Orcamento {
    public static function count() {
        return (int) db()->query("SELECT COUNT(*) FROM orcamentos")->fetchColumn();
    }

    // Retorna últimos 7 dias (label => total)
    public static function ultimos7Dias() {
        $dados = [];
        // Gera datas (hoje - 6 até hoje)
        for ($i = 6; $i >= 0; $i--) {
            $data = date('Y-m-d', strtotime("-{$i} days"));
            $dados[$data] = 0;
        }
        $stmt = db()->prepare("
            SELECT DATE(created_at) dia, COUNT(*) total
            FROM orcamentos
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
            GROUP BY dia
        ");
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            if (isset($dados[$row['dia']])) {
                $dados[$row['dia']] = (int)$row['total'];
            }
        }
        return $dados; // ex: ['2025-09-06'=>3, ...]
    }
}
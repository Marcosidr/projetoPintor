<?php
// LEGACY: usar service / repository no código novo.
class Orcamento {
    public static function count(): int {
        try { return (int) db()->query("SELECT COUNT(*) FROM orcamentos")?->fetchColumn(); } catch (Throwable) { return 0; }
    }
    public static function ultimos7Dias(): array {
        $dados = [];
        for ($i = 6; $i >= 0; $i--) { $data = date('Y-m-d', strtotime("-{$i} days")); $dados[$data]=0; }
        try {
            $st = db()->prepare("SELECT DATE(created_at) dia, COUNT(*) total FROM orcamentos WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY dia");
            $st->execute();
            foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $r) { if (isset($dados[$r['dia']])) $dados[$r['dia']] = (int)$r['total']; }
        } catch (Throwable) {}
        return $dados; // ['2025-09-06'=>3,...]
    }
}
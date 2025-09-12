<?php
// LEGACY: Mantido apenas para compat eventual. Prefira LoggerService / repositórios novos.
class Log {
    public static function countHoje(): int {
        try { return (int) db()->query("SELECT COUNT(*) FROM logs WHERE DATE(datahora)=CURDATE()")?->fetchColumn(); } catch (Throwable) { return 0; }
    }
    public static function recentes(int $limit = 5): array {
        try {
            $st = db()->prepare("SELECT * FROM logs ORDER BY datahora DESC LIMIT :l");
            $st->bindValue(':l', $limit, PDO::PARAM_INT); $st->execute(); return $st->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable) { return []; }
    }
}
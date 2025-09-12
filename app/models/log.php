<?php
class Log {
    public static function countHoje() {
        $stmt = db()->query("SELECT COUNT(*) FROM logs WHERE DATE(datahora) = CURDATE()");
        return (int) $stmt->fetchColumn();
    }

    public static function recentes($limit = 5) {
        $stmt = db()->prepare("SELECT * FROM logs ORDER BY datahora DESC LIMIT :l");
        $stmt->bindValue(':l', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
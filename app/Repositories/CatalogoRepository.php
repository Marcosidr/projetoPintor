<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

class CatalogoRepository {
    private PDO $db;

    public function __construct(?PDO $conn = null)
    {
        $this->db = $conn ?: Database::connection();
    }

    /** @return array<int,array<string,mixed>> */
    public function all(): array {
        $stmt = $this->db->query("SELECT id, titulo, arquivo, created_at FROM catalogos ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array {
        $st = $this->db->prepare("SELECT id, titulo, arquivo, created_at FROM catalogos WHERE id=? LIMIT 1");
        $st->execute([$id]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public function create(array $data): int {
        $st = $this->db->prepare("INSERT INTO catalogos (titulo, arquivo) VALUES (?, ?)");
        $st->execute([$data['titulo'], $data['arquivo']]);
        return (int)$this->db->lastInsertId();
    }
    
    /** Atualiza título e opcionalmente arquivo. $data pode conter 'titulo' e/ou 'arquivo'. */
    public function update(int $id, array $data): bool {
        $fields = [];$params=[]; 
        if (isset($data['titulo'])) { $fields[] = 'titulo = ?'; $params[] = $data['titulo']; }
        if (isset($data['arquivo'])) { $fields[] = 'arquivo = ?'; $params[] = $data['arquivo']; }
        if (!$fields) return false;
        $params[] = $id;
        $sql = 'UPDATE catalogos SET '.implode(',', $fields).' WHERE id = ?';
        $st = $this->db->prepare($sql);
        $st->execute($params);
        return $st->rowCount() > 0;
    }

    public function delete(int $id): bool {
        $st = $this->db->prepare("DELETE FROM catalogos WHERE id=?");
        $st->execute([$id]);
        return $st->rowCount() > 0;
    }
}

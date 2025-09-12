<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

/**
 * Repositório de Serviços - acessa a tabela `servicos`.
 * Retorna arrays associativos prontos para a view (sem acoplamento a objetos legacy).
 */
class ServicoRepository {

    private PDO $db;

    public function __construct(?PDO $conn = null)
    {
        $this->db = $conn ?: Database::connection();
    }

    /**
     * Lista todos os serviços ordenados por título.
     * @return array<int,array<string,mixed>>
     */
    public function all(): array
    {
        $sql = "SELECT id, icone, titulo, descricao, caracteristicas FROM servicos ORDER BY titulo";
        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll();
        foreach ($rows as &$row) {
            $row['caracteristicas'] = $this->decodeJsonArray($row['caracteristicas']);
        }
        return $rows;
    }

    /**
     * Busca um serviço por ID.
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, icone, titulo, descricao, caracteristicas FROM servicos WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        $row['caracteristicas'] = $this->decodeJsonArray($row['caracteristicas']);
        return $row;
    }

    /**
     * Cria um novo serviço.
     * @param array{icone:string,titulo:string,descricao:string,caracteristicas:array<int,string>} $data
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare("INSERT INTO servicos (icone, titulo, descricao, caracteristicas) VALUES (?, ?, ?, ?)");
        $json = json_encode(array_values($data['caracteristicas'] ?? []), JSON_UNESCAPED_UNICODE);
        $stmt->execute([
            $data['icone'],
            $data['titulo'],
            $data['descricao'],
            $json,
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Atualiza um serviço existente.
     * Retorna true se alguma linha foi afetada.
     */
    public function update(int $id, array $data): bool
    {
    // Uso de CURRENT_TIMESTAMP (compatível MySQL e SQLite) em vez de NOW() para facilitar testes.
    $stmt = $this->db->prepare("UPDATE servicos SET icone = ?, titulo = ?, descricao = ?, caracteristicas = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $json = json_encode(array_values($data['caracteristicas'] ?? []), JSON_UNESCAPED_UNICODE);
        $stmt->execute([
            $data['icone'],
            $data['titulo'],
            $data['descricao'],
            $json,
            $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Remove um serviço.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM servicos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Decodifica JSON e garante array.
     */
    private function decodeJsonArray(?string $json): array
    {
        if ($json === null || $json === '') return [];
        $data = json_decode($json, true);
        return is_array($data) ? $data : [];
    }
}

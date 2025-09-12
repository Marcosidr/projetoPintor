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
        try {
            $stmt = $this->db->query("SELECT id, icone, titulo, descricao, caracteristicas FROM servicos ORDER BY titulo");
        } catch (\Throwable $e) {
            $this->logRepo('all-fallback', $e->getMessage());
            // Fallback: coluna 'caracteristicas' pode não existir ainda
            $stmt = $this->db->query("SELECT id, icone, titulo, descricao FROM servicos ORDER BY titulo");
            $rows = $stmt->fetchAll();
            foreach ($rows as &$r) { $r['caracteristicas'] = []; }
            return $rows;
        }
        $rows = $stmt->fetchAll();
        foreach ($rows as &$row) {
            $row['caracteristicas'] = $this->decodeJsonArray($row['caracteristicas'] ?? '');
        }
        return $rows;
    }

    /**
     * Busca um serviço por ID.
     */
    public function find(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT id, icone, titulo, descricao, caracteristicas FROM servicos WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if (!$row) return null;
            $row['caracteristicas'] = $this->decodeJsonArray($row['caracteristicas'] ?? '');
            return $row;
        } catch (\Throwable $e) {
            $stmt = $this->db->prepare("SELECT id, icone, titulo, descricao FROM servicos WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if (!$row) return null;
            $row['caracteristicas'] = [];
            return $row;
        }
    }

    /**
     * Cria um novo serviço.
     * @param array{icone:string,titulo:string,descricao:string,caracteristicas:array<int,string>} $data
     */
    public function create(array $data): int
    {
        $caracts = array_values($data['caracteristicas'] ?? []);
        $json = json_encode($caracts, JSON_UNESCAPED_UNICODE);
        try {
            $stmt = $this->db->prepare("INSERT INTO servicos (icone, titulo, descricao, caracteristicas) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $data['icone'],
                $data['titulo'],
                $data['descricao'],
                $json,
            ]);
        } catch (\Throwable $e) {
            $this->logRepo('create-fallback', $e->getMessage());
            // Fallback sem coluna caracteristicas
            $stmt = $this->db->prepare("INSERT INTO servicos (icone, titulo, descricao) VALUES (?, ?, ?)");
            $stmt->execute([
                $data['icone'],
                $data['titulo'],
                $data['descricao'],
            ]);
        }
        return (int)$this->db->lastInsertId();
    }

    /**
     * Atualiza um serviço existente.
     * Retorna true se alguma linha foi afetada.
     */
    public function update(int $id, array $data): bool
    {
        // Carrega registro atual para permitir atualização parcial sem sobrescrever campos omitidos
        $atual = $this->find($id);
        if(!$atual) return false;
        $icone = $data['icone'] ?? $atual['icone'] ?? '';
        $titulo = $data['titulo'] ?? $atual['titulo'] ?? '';
        $descricao = $data['descricao'] ?? $atual['descricao'] ?? '';
        $caracts = array_key_exists('caracteristicas',$data) ? array_values($data['caracteristicas'] ?? []) : ($atual['caracteristicas'] ?? []);
        $json = json_encode($caracts, JSON_UNESCAPED_UNICODE);
        try {
            $stmt = $this->db->prepare("UPDATE servicos SET icone = ?, titulo = ?, descricao = ?, caracteristicas = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->execute([$icone,$titulo,$descricao,$json,$id]);
        } catch (\Throwable $e) {
            $this->logRepo('update-fallback', $e->getMessage());
            // Fallback sem coluna caracteristicas
            $stmt = $this->db->prepare("UPDATE servicos SET icone = ?, titulo = ?, descricao = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->execute([$icone,$titulo,$descricao,$id]);
        }
        return ($stmt->rowCount() > 0) || true; // Considera sucesso mesmo se dados idempotentes
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

    private function logRepo(string $evento, string $detalhe): void {
        try {
            $linha = date('c')."\tservicos\t$evento\t".preg_replace('/\s+/',' ', $detalhe)."\n";
            @file_put_contents(ROOT_PATH.'storage/logs/servicos-repo.log',$linha, FILE_APPEND);
        } catch(\Throwable $e) { /* silêncio */ }
    }
}

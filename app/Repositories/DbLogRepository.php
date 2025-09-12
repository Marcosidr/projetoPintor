<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

class DbLogRepository
{
    private PDO $db;
    public function __construct(?PDO $conn = null)
    {
        $this->db = $conn ?: Database::connection();
    }

    public function store(?int $userId, string $acao, array $ctx, ?string $ip, ?string $ua): void
    {
    $stmt = $this->db->prepare("INSERT INTO logs (ts, user_id, acao, ctx, ip, ua) VALUES (CURRENT_TIMESTAMP,?,?,?,?,?)");
        $json = json_encode($ctx, JSON_UNESCAPED_UNICODE);
        $stmt->execute([$userId, $acao, $json, $ip, $ua]);
    }

    /**
     * @return array{data:array<int,array<string,mixed>>,total:int,page:int,totalPages:int,perPage:int}
     */
    public function paginate(array $filtros, int $page = 1, int $perPage = 20): array
    {
        $where = [];
        $params = [];
        if (!empty($filtros['acao'])) { $where[] = 'acao LIKE ?'; $params[] = '%' . $filtros['acao'] . '%'; }
        if (!empty($filtros['data'])) { $where[] = 'DATE(ts) = ?'; $params[] = $filtros['data']; }
        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

        $countStmt = $this->db->prepare("SELECT COUNT(*) FROM logs $whereSql");
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();

        $totalPages = max(1, (int)ceil($total / $perPage));
        if ($page > $totalPages) $page = $totalPages;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $perPage;

        $stmt = $this->db->prepare("SELECT id, ts, user_id, acao, ctx, ip, ua FROM logs $whereSql ORDER BY ts DESC LIMIT $perPage OFFSET $offset");
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        foreach ($rows as &$r) {
            $decoded = json_decode($r['ctx'] ?? 'null', true);
            $r['ctx'] = is_array($decoded) ? $decoded : null;
        }
        return [
            'data' => $rows,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
        ];
    }
}
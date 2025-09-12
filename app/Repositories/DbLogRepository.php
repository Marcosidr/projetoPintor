<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

/**
 * Repositório de Logs (DB) resiliente a múltiplas versões de schema.
 *
 * Requisitos de compatibilidade encontrados durante depuração:
 *  - Tabelas podem ter ts | created_at | datahora (às vezes datahora NOT NULL sem default)
 *  - Colunas user_id, ip, ua, ctx podem estar ausentes em ambientes legados.
 *  - Necessidade de fallback quando user_id falha (p.ex. VIEW sem coluna ou permissão).
 *
 * Estratégia:
 *  - Detectar colunas na construção; criar 'ts' se nenhuma coluna temporal encontrada.
 *  - Flag booleana para cada coluna opcional evitando exceções futuras.
 *  - Store: constrói arrays de colunas/placeholders conforme flags.
 *  - Fallback runtime: se insert falhar por user_id, desativa flag e re-insere.
 *  - Paginação: SELECT alias para colunas faltantes (NULL AS user_id) mantendo formato uniforme para a view.
 */
class DbLogRepository
{
    private PDO $db;
    private string $tsColumn = 'ts'; // poderá ser ts | created_at | datahora conforme detectado
    private bool $hasUserId = true;
    private bool $hasIp = true;
    private bool $hasUa = true;
    private bool $hasCtx = true;

    public function __construct(?PDO $conn = null)
    {
        $this->db = $conn ?: Database::connection();
        try {
            $cols = $this->db->query("SHOW COLUMNS FROM logs")->fetchAll(PDO::FETCH_COLUMN);
            // Prioridade temporal: ts > created_at > datahora. Cria ts se nada conhecido.
            if (in_array('ts', $cols, true)) {
                $this->tsColumn = 'ts';
            } elseif (in_array('created_at', $cols, true)) {
                $this->tsColumn = 'created_at';
            } elseif (in_array('datahora', $cols, true)) {
                $this->tsColumn = 'datahora';
            } else {
                // Migração suave: cria coluna ts padrão.
                $this->db->exec("ALTER TABLE logs ADD COLUMN ts DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER id");
                $this->tsColumn = 'ts';
            }
            // Flags de colunas opcionais (evita montar SQL com colunas inexistentes).
            $this->hasUserId = in_array('user_id', $cols, true);
            $this->hasIp = in_array('ip', $cols, true);
            $this->hasUa = in_array('ua', $cols, true);
            $this->hasCtx = in_array('ctx', $cols, true);
        } catch (\Throwable $e) {
            // Mantém defaults; erros posteriores revelarão problema real ao chamador (não suprimimos totalmente).
        }
    }

    /**
     * Insere um log tolerante a variações de schema.
     * Se a coluna temporal for 'datahora' (sem default), injeta valor manual.
     * Fallback: erro envolvendo 'user_id' provoca segunda tentativa sem a coluna.
     */
    public function store(?int $userId, string $acao, array $ctx, ?string $ip, ?string $ua): void
    {
        $json = json_encode($ctx, JSON_UNESCAPED_UNICODE);
        $cols = [];$placeholders=[];$values=[];
        $needsExplicitTs = ($this->tsColumn === 'datahora'); // datahora sem default exige NOW manual.
        if ($needsExplicitTs) { $cols[] = $this->tsColumn; $placeholders[]='?'; $values[] = date('Y-m-d H:i:s'); }
        if ($this->hasUserId) { $cols[]='user_id'; $placeholders[]='?'; $values[]=$userId; }
        $cols[]='acao'; $placeholders[]='?'; $values[]=$acao;
        if ($this->hasCtx) { $cols[]='ctx'; $placeholders[]='?'; $values[]=$json; }
        if ($this->hasIp) { $cols[]='ip'; $placeholders[]='?'; $values[]=$ip; }
        if ($this->hasUa) { $cols[]='ua'; $placeholders[]='?'; $values[]=$ua; }
        $sql='INSERT INTO logs (' . implode(',', $cols) . ') VALUES (' . implode(',', $placeholders) . ')';
        $stmt=$this->db->prepare($sql);
        try {
            $stmt->execute($values);
        } catch (\Throwable $e) {
            // Se a coluna user_id causar erro (ex: vista distinta ou corrida de migração) remove e tenta de novo.
            if ($this->hasUserId && stripos($e->getMessage(), 'user_id') !== false) {
                $this->hasUserId = false; // desativa para chamadas futuras (auto-aprendizado).
                $reCols = [];$rePH=[];$reVals=[];
                if ($needsExplicitTs) { $reCols[]=$this->tsColumn; $rePH[]='?'; $reVals[]=date('Y-m-d H:i:s'); }
                $reCols[]='acao'; $rePH[]='?'; $reVals[]=$acao;
                if ($this->hasCtx) { $reCols[]='ctx'; $rePH[]='?'; $reVals[]=$json; }
                if ($this->hasIp) { $reCols[]='ip'; $rePH[]='?'; $reVals[]=$ip; }
                if ($this->hasUa) { $reCols[]='ua'; $rePH[]='?'; $reVals[]=$ua; }
                $retrySql='INSERT INTO logs (' . implode(',', $reCols) . ') VALUES (' . implode(',', $rePH) . ')';
                $this->db->prepare($retrySql)->execute($reVals);
            } else {
                throw $e; // Propaga para que logger superior registre fallback em arquivo.
            }
        }
    }

    /**
     * Paginação tolerante: substitui colunas ausentes por NULL para resposta uniforme.
     * @return array{data:array<int,array<string,mixed>>,total:int,page:int,totalPages:int,perPage:int}
     */
    public function paginate(array $filtros, int $page = 1, int $perPage = 20): array
    {
        $where = [];
        $params = [];
        if (!empty($filtros['acao'])) { $where[] = 'acao LIKE ?'; $params[] = '%' . $filtros['acao'] . '%'; }
        if (!empty($filtros['data'])) { $where[] = 'DATE(' . $this->tsColumn . ') = ?'; $params[] = $filtros['data']; }
        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

        $countStmt = $this->db->prepare("SELECT COUNT(*) FROM logs $whereSql");
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();

        $totalPages = max(1, (int)ceil($total / $perPage));
        if ($page > $totalPages) $page = $totalPages;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $perPage;

        // Seleção resiliente: colunas inexistentes viram NULL AS <nome> para manter front simples.
        $selectParts = ['id', $this->tsColumn . ' AS ts'];
        $selectParts[] = $this->hasUserId ? 'user_id' : 'NULL AS user_id';
        $selectParts[] = 'acao';
        $selectParts[] = $this->hasCtx ? 'ctx' : 'NULL AS ctx';
        $selectParts[] = $this->hasIp ? 'ip' : 'NULL AS ip';
        $selectParts[] = $this->hasUa ? 'ua' : 'NULL AS ua';
        $stmt = $this->db->prepare("SELECT " . implode(',', $selectParts) . " FROM logs $whereSql ORDER BY " . $this->tsColumn . " DESC LIMIT $perPage OFFSET $offset");
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        foreach ($rows as &$r) {
            $decoded = json_decode($r['ctx'] ?? 'null', true);
            $r['ctx'] = is_array($decoded) ? $decoded : null; // garante estrutura consistente.
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

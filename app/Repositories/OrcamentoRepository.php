<?php
namespace App\Repositories;

use App\Core\Database; use PDO;

/**
 * Repositório de Orçamentos com inserção resiliente a variações de schema.
 *
 * Objetivo: permitir que o formulário funcione mesmo que o banco do cliente
 * tenha nomes de colunas ligeiramente diferentes ou algumas ausentes.
 * Estratégia: DESCobre (via SHOW COLUMNS) uma vez por request quais colunas
 * existem e constrói dinamicamente o INSERT apenas com elas. Assim evitamos
 * erros "Unknown column" e não precisamos de migração obrigatória.
 */
class OrcamentoRepository {
    /**
     * Cria um novo orçamento adaptando-se às colunas disponíveis.
     * Campos mínimos assumidos: nome, email, telefone.
     * Campos opcionais: servico, mensagem, extras (JSON), criado_em|created_at.
     */
    public function create(array $data): int {
        $conn = Database::connection();
        // Cache estático simples evita repetir SHOW COLUMNS em múltiplos inserts no mesmo request.
        static $cols = null;
        if ($cols === null) {
            $cols = [];
            try {
                $rs = $conn->query("SHOW COLUMNS FROM orcamentos");
                foreach ($rs->fetchAll() as $row) { $cols[$row['Field']] = true; }
            } catch (\Throwable $e) {
                // Falha (permissão / table inexistente): assume um conjunto mínimo para não quebrar.
                $cols = ['nome'=>true,'email'=>true,'telefone'=>true,'servico'=>true,'mensagem'=>true,'criado_em'=>true];
            }
        }

        // Inicia sempre com campos obrigatórios.
        $fields = ['nome','email','telefone'];
        $params = ['n'=>$data['nome'],'e'=>$data['email'],'t'=>$data['telefone']];

        // Campos opcionais conforme realmente existam no schema.
        if (isset($cols['servico'])) { $fields[] = 'servico'; $params['s'] = $data['servico'] ?? ''; }
        if (isset($cols['mensagem'])) { $fields[] = 'mensagem'; $params['m'] = $data['mensagem'] ?? ''; }

        // 'extras' (array/objeto) é serializado para JSON apenas se existir coluna e valor.
        $hasExtras = isset($cols['extras']) && isset($data['extras']);
        if ($hasExtras) { $fields[] = 'extras'; $params['x'] = json_encode($data['extras'], JSON_UNESCAPED_UNICODE); }

        // Timestamp preferencial: criado_em > created_at > (nenhum => sem timestamp explícito, rely em default DB se existir)
        $timestampCol = isset($cols['criado_em']) ? 'criado_em' : (isset($cols['created_at']) ? 'created_at' : null);

        // Mapeia cada campo para um placeholder fixo (segurança: nada de concatenar valores diretos).
        $placeholders = [];
        foreach ($fields as $f) {
            switch ($f) {
                case 'nome': $placeholders[]=':n'; break;
                case 'email': $placeholders[]=':e'; break;
                case 'telefone': $placeholders[]=':t'; break;
                case 'servico': $placeholders[]=':s'; break;
                case 'mensagem': $placeholders[]=':m'; break;
                case 'extras': $placeholders[]=':x'; break; // JSON
            }
        }

        // Concatena SQL final adicionando NOW() somente se a coluna existir.
        $fieldsSql = implode(',', $fields) . ($timestampCol ? (','.$timestampCol) : '');
        $phSql = implode(',', $placeholders) . ($timestampCol ? ',NOW()' : '');
        $sql = "INSERT INTO orcamentos ($fieldsSql) VALUES ($phSql)";

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return (int)$conn->lastInsertId();
    }

    /** Número total de registros (usado em testes / métricas simples). */
    public function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM orcamentos')->fetchColumn();
    }
}

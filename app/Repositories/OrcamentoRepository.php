<?php
namespace App\Repositories;

use App\Core\Database; use PDO;

class OrcamentoRepository {
    public function create(array $data): int {
        $conn = Database::connection();
        // Descobre colunas existentes uma única vez por request (cache simples static)
        static $cols = null;
        if ($cols === null) {
            $cols = [];
            try {
                $rs = $conn->query("SHOW COLUMNS FROM orcamentos");
                foreach ($rs->fetchAll() as $row) { $cols[$row['Field']] = true; }
            } catch (\Throwable $e) {
                // Se SHOW COLUMNS falhar, assume esquema mínimo
                $cols = ['nome'=>true,'email'=>true,'telefone'=>true,'servico'=>true,'mensagem'=>true,'criado_em'=>true];
            }
        }

        $fields = ['nome','email','telefone'];
        $params = ['n'=>$data['nome'],'e'=>$data['email'],'t'=>$data['telefone']];

        // 'servico' pode estar ausente no schema do usuário
        if (isset($cols['servico'])) { $fields[] = 'servico'; $params['s'] = $data['servico'] ?? ''; }
        if (isset($cols['mensagem'])) { $fields[] = 'mensagem'; $params['m'] = $data['mensagem'] ?? ''; }

        $hasExtras = isset($cols['extras']) && isset($data['extras']);
        if ($hasExtras) { $fields[] = 'extras'; $params['x'] = json_encode($data['extras'], JSON_UNESCAPED_UNICODE); }

        // Coluna de timestamp: criado_em ou created_at (fallback)
        $timestampCol = isset($cols['criado_em']) ? 'criado_em' : (isset($cols['created_at']) ? 'created_at' : null);
        $valuesSql = [];
        $placeholders = [];
        foreach ($fields as $f) {
            switch ($f) {
                case 'nome': $placeholders[]=':n'; break;
                case 'email': $placeholders[]=':e'; break;
                case 'telefone': $placeholders[]=':t'; break;
                case 'servico': $placeholders[]=':s'; break;
                case 'mensagem': $placeholders[]=':m'; break;
                case 'extras': $placeholders[]=':x'; break;
            }
        }
        $fieldsSql = implode(',', $fields) . ($timestampCol ? (','.$timestampCol) : '');
        $phSql = implode(',', $placeholders) . ($timestampCol ? ',NOW()' : '');
        $sql = "INSERT INTO orcamentos ($fieldsSql) VALUES ($phSql)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return (int)$conn->lastInsertId();
    }

    public function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM orcamentos')->fetchColumn();
    }
}

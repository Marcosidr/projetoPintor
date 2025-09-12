<?php
namespace App\Repositories;

use App\Core\Database; use PDO;

class OrcamentoRepository {
    public function create(array $data): int {
        $conn = Database::connection();
        $extrasJson = isset($data['extras']) ? json_encode($data['extras'], JSON_UNESCAPED_UNICODE) : null;
        // Tentativa com coluna extras (JSON/TEXT opcional)
        try {
            if ($extrasJson !== null) {
                $sql = 'INSERT INTO orcamentos (nome,email,telefone,servico,mensagem,extras,criado_em) VALUES (:n,:e,:t,:s,:m,:x,NOW())';
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'n'=>$data['nome'],
                    'e'=>$data['email'],
                    't'=>$data['telefone'],
                    's'=>$data['servico'],
                    'm'=>$data['mensagem'],
                    'x'=>$extrasJson
                ]);
                return (int)$conn->lastInsertId();
            }
            throw new \RuntimeException('Sem extras fornecidos, cai para fallback');
        } catch (\Throwable $e) {
            // Fallback sem coluna extras
            $sql = 'INSERT INTO orcamentos (nome,email,telefone,servico,mensagem,criado_em) VALUES (:n,:e,:t,:s,:m,NOW())';
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'n'=>$data['nome'],
                'e'=>$data['email'],
                't'=>$data['telefone'],
                's'=>$data['servico'],
                'm'=>$data['mensagem']
            ]);
        }
        return (int) $conn->lastInsertId();
    }

    public function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM orcamentos')->fetchColumn();
    }
}

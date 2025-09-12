<?php
namespace App\Repositories;

use App\Core\Database; use PDO;

class OrcamentoRepository {
    public function create(array $data): int {
        $sql = 'INSERT INTO orcamentos (nome,email,telefone,servico,mensagem,created_at) VALUES (:n,:e,:t,:s,:m,NOW())';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute([
            'n'=>$data['nome'],
            'e'=>$data['email'],
            't'=>$data['telefone'],
            's'=>$data['servico'],
            'm'=>$data['mensagem']
        ]);
        return (int) Database::connection()->lastInsertId();
    }

    public function count(): int {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM orcamentos')->fetchColumn();
    }
}

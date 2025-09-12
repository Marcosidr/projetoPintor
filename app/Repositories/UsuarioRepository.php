<?php
namespace App\Repositories;

use App\Core\Database; use PDO;

class UsuarioRepository {
    private ?string $createdCol = null;

    private function createdColumn(): string {
        if ($this->createdCol) return $this->createdCol;
        // Detecta dinamicamente similar ao DashboardService
        $pdo = Database::connection();
        try {
            $cols = $pdo->query("SHOW COLUMNS FROM usuarios")->fetchAll(PDO::FETCH_COLUMN);
            foreach (['created_at','criado_em','ts'] as $c) {
                if (in_array($c, $cols, true)) { $this->createdCol = $c; return $c; }
            }
        } catch (\Throwable $e) {
            // fallback silencioso
        }
        $this->createdCol = 'criado_em';
        return $this->createdCol;
    }
    public function findByEmail(string $email): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM usuarios WHERE email = :e LIMIT 1');
        $stmt->execute(['e'=>$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
    public function create(array $data): int {
        $stmt = Database::connection()->prepare('INSERT INTO usuarios (nome,email,senha,tipo) VALUES (:n,:e,:s,:t)');
        $stmt->execute(['n'=>$data['nome'],'e'=>$data['email'],'s'=>$data['senha'],'t'=>$data['tipo'] ?? 'user']);
        return (int) Database::connection()->lastInsertId();
    }
    public function all(): array {
        $col = $this->createdColumn();
        $pdo = Database::connection();
        $stmt = $pdo->query("SELECT id,nome,email,tipo,$col AS created_at FROM usuarios ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function count(): int { return (int) Database::connection()->query('SELECT COUNT(*) FROM usuarios')->fetchColumn(); }
    public function countAdmins(): int { return (int) Database::connection()->query("SELECT COUNT(*) FROM usuarios WHERE tipo='admin'")->fetchColumn(); }
    public function findById(int $id): ?array {
        $stmt = Database::connection()->prepare('SELECT * FROM usuarios WHERE id=:i');
        $stmt->execute(['i'=>$id]);
        $u = $stmt->fetch(PDO::FETCH_ASSOC); return $u ?: null;
    }
    public function update(int $id, array $data): bool {
        $fields = []; $params=['id'=>$id];
        foreach(['nome','email','tipo','senha'] as $f){ if(isset($data[$f])) { $fields[]="$f=:$f"; $params[$f]=$data[$f]; }}
        if (!$fields) return false;
        $sql = 'UPDATE usuarios SET '.implode(',', $fields).' WHERE id=:id';
        $stmt = Database::connection()->prepare($sql); return $stmt->execute($params);
    }
    public function delete(int $id): bool {
        $stmt = Database::connection()->prepare('DELETE FROM usuarios WHERE id=:i');
        return $stmt->execute(['i'=>$id]);
    }
    public function toggleAdmin(int $id): bool {
        $u = $this->findById($id); if(!$u) return false; $novo = ($u['tipo']==='admin') ? 'user':'admin';
        return $this->update($id, ['tipo'=>$novo]);
    }
    public function resetSenha(int $id, string $novaSenhaHash): bool { return $this->update($id, ['senha'=>$novaSenhaHash]); }
}

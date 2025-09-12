<?php
namespace App\Repositories;

use App\Core\Database; use PDO;

class UsuarioRepository {
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
    public function all(): array { return Database::connection()->query('SELECT id,nome,email,tipo,created_at FROM usuarios ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC); }
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

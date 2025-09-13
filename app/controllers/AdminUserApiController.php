<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Response;
use App\Repositories\UsuarioRepository;

class AdminUserApiController
{
    public function __construct(private UsuarioRepository $repo = new UsuarioRepository()) {}

    /** DEBUG: logger temporário. Remove após diagnóstico. */
    private function dbg(string $etapa, array $extra = []): void {
        try {
            $logDir = __DIR__ . '/../../storage/logs';
            if (!is_dir($logDir)) @mkdir($logDir, 0777, true);
            $payload = [
                'ts' => date('c'),
                'etapa' => $etapa,
                'uri' => $_SERVER['REQUEST_URI'] ?? null,
                'method' => $_SERVER['REQUEST_METHOD'] ?? null,
                'is_admin' => \App\Core\Auth::checkAdmin(),
                'post_keys' => array_keys($_POST ?: []),
                'csrf_header' => $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null,
                'session_id' => session_id(),
            ] + $extra;
            file_put_contents($logDir . '/api-users-debug.log', json_encode($payload, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
        } catch (\Throwable $e) {
            // silencia
        }
    }

    private function json(array $data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function guardAdmin(): bool {
        if (!Auth::checkAdmin()) { $this->dbg('nao_admin'); $this->json(['success'=>false,'message'=>'Não autorizado'],403); return false; }
        return true;
    }

    private function validateCsrf(): bool {
        $token = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!Csrf::validate($token)) { $this->dbg('csrf_invalido', ['token_recv'=>$token]); $this->json(['success'=>false,'message'=>'CSRF inválido'],419); return false; }
        return true;
    }

    public function index(): void {
        $this->dbg('index_ini');
        if(!$this->guardAdmin()) return;
        $users = $this->repo->all();
        $this->dbg('index_ok', ['qtd'=>count($users)]);
        $this->json(['success'=>true,'data'=>$users]);
    }

    public function store(): void {
        $this->dbg('store_ini');
        if(!$this->guardAdmin() || !$this->validateCsrf()) return;
    $nome = trim($_POST['nome'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
        $senha = $_POST['senha'] ?? '';
        $tipo  = $_POST['tipo'] ?? 'user';
        $erros = [];
    if($nome===''){ $erros[]='Nome obrigatório'; } elseif(mb_strlen($nome) > 100){ $erros[]='Nome muito longo'; }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ $erros[]='Email inválido'; } elseif(mb_strlen($email) > 150){ $erros[]='Email muito longo'; }
        if(strlen($senha) < 6){ $erros[]='Senha mínima 6 caracteres'; }
        if(!in_array($tipo,['user','admin'],true)){ $erros[]='Tipo inválido'; }
        if($erros){ $this->dbg('store_valid_err', ['erros'=>$erros]); $this->json(['success'=>false,'errors'=>$erros],422); return; }
        try {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $id = $this->repo->create(['nome'=>$nome,'email'=>$email,'senha'=>$hash,'tipo'=>$tipo]);
            $user = $this->repo->findById($id);
            $this->dbg('store_ok', ['id'=>$id]);
            $this->json(['success'=>true,'data'=>$user,'message'=>'Usuário criado'],201);
        } catch(\Throwable $e){
            $this->dbg('store_exc', ['err'=>$e->getMessage()]);
            $this->json(['success'=>false,'message'=>'Erro ao criar (email duplicado?)'],500);
        }
    }

    public function update(int $id): void {
        $this->dbg('update_ini', ['id'=>$id]);
        if(!$this->guardAdmin() || !$this->validateCsrf()) return;
        $user = $this->repo->findById($id); if(!$user){ $this->json(['success'=>false,'message'=>'Não encontrado'],404); return; }
        $data=[];$erros=[];
    if(isset($_POST['nome'])){ $nome=trim($_POST['nome']); if($nome===''){ $erros[]='Nome obrigatório'; } elseif(mb_strlen($nome)>100){ $erros[]='Nome muito longo'; } else { $data['nome']=$nome; } }
    if(isset($_POST['email'])){ $email=strtolower(trim($_POST['email'])); if(!filter_var($email,FILTER_VALIDATE_EMAIL)){ $erros[]='Email inválido'; } elseif(mb_strlen($email)>150){ $erros[]='Email muito longo'; } else { $data['email']=$email; } }
        if(isset($_POST['tipo'])){ $tipo=$_POST['tipo']; if(!in_array($tipo,['user','admin'],true)){ $erros[]='Tipo inválido'; } else { $data['tipo']=$tipo; } }
        if(isset($_POST['senha']) && $_POST['senha']!==''){ if(strlen($_POST['senha'])<6){ $erros[]='Senha curta'; } else { $data['senha']=password_hash($_POST['senha'],PASSWORD_DEFAULT); } }
        if($erros){ $this->dbg('update_valid_err', ['id'=>$id,'erros'=>$erros]); $this->json(['success'=>false,'errors'=>$erros],422); return; }
        if(!$data){ $this->dbg('update_nada', ['id'=>$id]); $this->json(['success'=>false,'message'=>'Nada para atualizar'],400); return; }
        $ok = $this->repo->update($id,$data);
        $user = $this->repo->findById($id);
        $this->dbg('update_fim', ['id'=>$id,'ok'=>$ok]);
        $this->json(['success'=>$ok,'data'=>$user,'message'=>$ok?'Atualizado':'Falha ao atualizar'], $ok?200:500);
    }

    public function destroy(int $id): void {
        $this->dbg('destroy_ini', ['id'=>$id]);
        if(!$this->guardAdmin() || !$this->validateCsrf()) return;
        $user = $this->repo->findById($id); if(!$user){ $this->json(['success'=>false,'message'=>'Não encontrado'],404); return; }
        $ok = $this->repo->delete($id);
        $this->dbg('destroy_fim', ['id'=>$id,'ok'=>$ok]);
        $this->json(['success'=>$ok,'message'=>$ok?'Removido':'Falha ao remover'], $ok?200:500);
    }

    public function resetSenha(int $id): void {
        $this->dbg('reset_ini', ['id'=>$id]);
        if(!$this->guardAdmin() || !$this->validateCsrf()) return;
        $user = $this->repo->findById($id); if(!$user){ $this->json(['success'=>false,'message'=>'Não encontrado'],404); return; }
        $novaHash = password_hash('reset123', PASSWORD_DEFAULT);
        $ok = $this->repo->resetSenha($id,$novaHash);
        $this->dbg('reset_fim', ['id'=>$id,'ok'=>$ok]);
        $this->json(['success'=>$ok,'message'=>$ok?'Senha redefinida para reset123':'Falha ao resetar'], $ok?200:500);
    }

    public function toggleAdmin(int $id): void {
        $this->dbg('toggle_ini', ['id'=>$id]);
        if(!$this->guardAdmin() || !$this->validateCsrf()) return;
        $user = $this->repo->findById($id); if(!$user){ $this->json(['success'=>false,'message'=>'Não encontrado'],404); return; }
        $ok = $this->repo->toggleAdmin($id);
        $novo = $this->repo->findById($id);
        $this->dbg('toggle_fim', ['id'=>$id,'ok'=>$ok]);
        $this->json(['success'=>$ok,'data'=>$novo,'message'=>$ok?'Perfil atualizado':'Falha ao atualizar'], $ok?200:500);
    }
}

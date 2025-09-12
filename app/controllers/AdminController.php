<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Response;
use App\Core\Csrf;
use App\Core\Session;
use App\Repositories\UsuarioRepository;

class AdminController extends Controller {
    public function __construct(private UsuarioRepository $repo = new UsuarioRepository()) {}

    private function guard(): void { if (!Auth::checkAdmin()) { Response::redirect(BASE_URL . '/painel'); } }

    public function index(): void { $this->guard(); $users = $this->repo->all(); $this->view('admin/gerenciar', compact('users')); }

    public function create(): void { $this->guard(); $this->view('admin/create'); }

    public function store(): void {
        $this->guard(); if(!Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF'); }
        $nome=trim($_POST['nome']??''); $email=strtolower(trim($_POST['email']??'')); $senha=$_POST['senha']??''; $tipo=$_POST['tipo']??'user';
        if($nome===''||$email===''||$senha===''){ Session::set('erro_admin','Campos obrigatórios.'); Response::redirect(BASE_URL.'/admin/create'); }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){ Session::set('erro_admin','Email inválido'); Response::redirect(BASE_URL.'/admin/create'); }
        if(strlen($senha)<6){ Session::set('erro_admin','Senha mínima 6 chars'); Response::redirect(BASE_URL.'/admin/create'); }
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        try { $this->repo->create(['nome'=>$nome,'email'=>$email,'senha'=>$hash,'tipo'=>$tipo]); Session::set('sucesso_admin','Usuário criado'); }
        catch(\Throwable $e){ Session::set('erro_admin','Erro ao criar (email duplicado?)'); }
        Response::redirect(BASE_URL.'/admin');
    }

    public function edit(int $id): void { $this->guard(); $user=$this->repo->findById($id); if(!$user){ Response::redirect(BASE_URL.'/admin'); } $this->view('admin/edit', compact('user')); }

    public function update(int $id): void {
        $this->guard(); if(!Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF'); }
        $data=[]; foreach(['nome','email','tipo'] as $f){ if(isset($_POST[$f]) && $_POST[$f] !== '') $data[$f]=trim($_POST[$f]); }
        if(isset($_POST['senha']) && $_POST['senha']!==''){ if(strlen($_POST['senha'])<6){ Session::set('erro_admin','Senha curta'); Response::redirect(BASE_URL.'/admin/edit/'.$id); } $data['senha']=password_hash($_POST['senha'],PASSWORD_DEFAULT); }
        if(!$data){ Session::set('erro_admin','Nada para atualizar'); Response::redirect(BASE_URL.'/admin/edit/'.$id); }
        $ok=$this->repo->update($id,$data); Session::set($ok?'sucesso_admin':'erro_admin',$ok?'Atualizado':'Falha ao atualizar');
        Response::redirect(BASE_URL.'/admin');
    }

    public function destroy(int $id): void { $this->guard(); if(!Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF'); } $this->repo->delete($id); Session::set('sucesso_admin','Removido'); Response::redirect(BASE_URL.'/admin'); }
    public function toggleAdmin(int $id): void { $this->guard(); if(!Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF'); } $this->repo->toggleAdmin($id); Session::set('sucesso_admin','Perfil atualizado'); Response::redirect(BASE_URL.'/admin'); }
    public function resetSenha(int $id): void { $this->guard(); if(!Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF'); } $nova=password_hash('reset123',PASSWORD_DEFAULT); $this->repo->resetSenha($id,$nova); Session::set('sucesso_admin','Senha redefinida para reset123'); Response::redirect(BASE_URL.'/admin'); }
}

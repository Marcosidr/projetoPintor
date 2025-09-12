<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Repositories\ServicoRepository;

class AdminServicoApiController
{
    public function __construct(private ServicoRepository $repo = new ServicoRepository()) {}

    private function json(array $data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function guardAdmin(): bool {
        if(!Auth::checkAdmin()) { $this->json(['success'=>false,'message'=>'Não autorizado'],403); return false; }
        return true;
    }
    private function validateCsrf(): bool {
        $token = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if(!Csrf::validate($token)) { $this->json(['success'=>false,'message'=>'CSRF inválido'],419); return false; }
        return true;
    }

    public function index(): void {
        if(!$this->guardAdmin()) return;
        try {
            $servicos = $this->repo->all();
            if(isset($_GET['_debug'])) {
                $count = count($servicos);
                $sample = $count ? array_slice($servicos,0,2) : [];
                $this->json([
                    'success'=>true,
                    'data'=>$servicos,
                    'debug'=>[
                        'count'=>$count,
                        'sample'=>$sample,
                        'db_name'=>\App\Core\Env::get('DB_NAME','(default)')
                    ]
                ]);
                return;
            }
            $this->json(['success'=>true,'data'=>$servicos]);
        } catch(\Throwable $e){
            $this->json(['success'=>false,'message'=>'Falha ao listar serviços','error'=>$e->getMessage()],500);
        }
    }

    public function store(): void {
        if(!$this->guardAdmin() || !$this->validateCsrf()) return;
        $icone = trim($_POST['icone'] ?? '');
        $titulo = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $caracteristicasRaw = $_POST['caracteristicas'] ?? '';
        $erros=[];
        if($titulo===''){ $erros[]='Título obrigatório'; } elseif(mb_strlen($titulo) > 120) { $erros[]='Título muito longo'; }
        if($descricao===''){ $erros[]='Descrição obrigatória'; }
        $caracteristicas = [];
        if($caracteristicasRaw!==''){
            // Aceita input separado por quebras de linha
            $lines = preg_split('/\r?\n/', $caracteristicasRaw);
            foreach($lines as $l){ $l = trim($l); if($l!=='') $caracteristicas[]=$l; }
        }
        if($erros){ $this->json(['success'=>false,'errors'=>$erros],422); return; }
        try {
            $id = $this->repo->create([
                'icone'=>$icone ?: 'bi bi-gear',
                'titulo'=>$titulo,
                'descricao'=>$descricao,
                'caracteristicas'=>$caracteristicas,
            ]);
            $novo = $this->repo->find($id);
            $this->json(['success'=>true,'data'=>$novo,'message'=>'Serviço criado'],201);
        } catch(\Throwable $e){
            $this->json(['success'=>false,'message'=>'Erro ao criar serviço'],500);
        }
    }

    public function update(int $id): void {
        if(!$this->guardAdmin() || !$this->validateCsrf()) return;
        $serv = $this->repo->find($id); if(!$serv){ $this->json(['success'=>false,'message'=>'Não encontrado'],404); return; }
        $data=[]; $erros=[];
        if(array_key_exists('icone', $_POST)){ $ic = trim($_POST['icone']); if($ic!=='' && mb_strlen($ic) > 80){ $erros[]='Ícone muito longo'; } else { if($ic!=='') $data['icone']=$ic; }}
        if(array_key_exists('titulo', $_POST)){ $ti = trim($_POST['titulo']); if($ti===''){ $erros[]='Título obrigatório'; } elseif(mb_strlen($ti)>120){ $erros[]='Título longo'; } else { $data['titulo']=$ti; }}
        if(array_key_exists('descricao', $_POST)){ $de = trim($_POST['descricao']); if($de===''){ $erros[]='Descrição obrigatória'; } else { $data['descricao']=$de; }}
        if(isset($_POST['caracteristicas'])){
            $caracts=[]; $lines=preg_split('/\r?\n/', $_POST['caracteristicas']);
            foreach($lines as $l){ $l=trim($l); if($l!=='') $caracts[]=$l; }
            $data['caracteristicas']=$caracts;
        }
        if($erros){ $this->json(['success'=>false,'errors'=>$erros],422); return; }
        if(!$data){ $this->json(['success'=>false,'message'=>'Nada para atualizar'],400); return; }
        $ok = $this->repo->update($id,$data);
        $novo = $this->repo->find($id);
        $this->json(['success'=>$ok,'data'=>$novo,'message'=>$ok?'Atualizado':'Falha ao atualizar'], $ok?200:500);
    }

    public function destroy(int $id): void {
        if(!$this->guardAdmin() || !$this->validateCsrf()) return;
        $serv = $this->repo->find($id); if(!$serv){ $this->json(['success'=>false,'message'=>'Não encontrado'],404); return; }
        $ok = $this->repo->delete($id);
        $this->json(['success'=>$ok,'message'=>$ok?'Removido':'Falha ao remover'], $ok?200:500);
    }
}

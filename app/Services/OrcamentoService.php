<?php
namespace App\Services;

use App\Repositories\OrcamentoRepository;

class OrcamentoService {
    /** @var object repo com método create(array):int */
    private $repo;
    public function __construct($repo = null) {
        $this->repo = $repo ?? new OrcamentoRepository();
    }

    public function criar(array $data): array {
        $nome = trim($data['nome'] ?? '');
        $email = strtolower(trim($data['email'] ?? ''));
        $telefone = trim($data['telefone'] ?? '');
        $servico = trim($data['servico'] ?? '');
        $mensagem = trim($data['mensagem'] ?? '');

        if ($nome===''||$email===''||$telefone===''||$servico==='') {
            return ['ok'=>false,'error'=>'Preencha os campos obrigatórios.'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['ok'=>false,'error'=>'E-mail inválido.'];
        }
        if (strlen($mensagem) > 1000) {
            return ['ok'=>false,'error'=>'Mensagem muito longa.'];
        }
        $id = $this->repo->create([
            'nome'=>$nome,
            'email'=>$email,
            'telefone'=>$telefone,
            'servico'=>$servico,
            'mensagem'=>$mensagem
        ]);
        return ['ok'=>true,'id'=>$id];
    }
}

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
        // Campo 'servico' legacy: vamos mapear para tipoServico se existir
        $servico = trim($data['servico'] ?? ($data['tipoServico'] ?? ''));
        $mensagem = trim($data['mensagem'] ?? ($data['observacoes'] ?? ''));
        $endereco = trim($data['endereco'] ?? '');
        $tipoImovel = trim($data['tipoImovel'] ?? '');
        $tipoServico = trim($data['tipoServico'] ?? '');
        $area = trim($data['area'] ?? '');
        $urgencia = trim($data['urgencia'] ?? '');
        $necessidades = $data['necessidades'] ?? [];

        if ($nome===''||$email===''||$telefone===''||$servico==='') {
            return ['ok'=>false,'error'=>'Preencha os campos obrigatórios.'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['ok'=>false,'error'=>'E-mail inválido.'];
        }
        if (strlen($mensagem) > 1000) {
            return ['ok'=>false,'error'=>'Mensagem muito longa.'];
        }
        $extras = [
            'endereco'=>$endereco,
            'tipoImovel'=>$tipoImovel,
            'tipoServico'=>$tipoServico,
            'area'=>$area,
            'urgencia'=>$urgencia,
            'necessidades'=>is_array($necessidades)? array_values($necessidades):[],
        ];
        $id = $this->repo->create([
            'nome'=>$nome,
            'email'=>$email,
            'telefone'=>$telefone,
            'servico'=>$servico,
            'mensagem'=>$mensagem,
            'extras'=>$extras
        ]);
        return ['ok'=>true,'id'=>$id];
    }
}

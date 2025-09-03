<?php
header('Content-Type: application/json');
require 'config.php';

try {
    // 🔎 Debug - salva os dados recebidos em um arquivo
    file_put_contents(__DIR__ . "/debug.txt", print_r($_POST, true));

    $nome        = trim($_POST['nome'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $telefone    = trim($_POST['telefone'] ?? '');
    $endereco    = trim($_POST['endereco'] ?? '');
    $tipoImovel  = $_POST['tipoImovel'] ?? '';
    $tipoServico = $_POST['tipoServico'] ?? '';
    $area        = isset($_POST['area']) && $_POST['area'] !== '' ? $_POST['area'] : null;
    $urgencia    = $_POST['urgencia'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';
    $necessidades = isset($_POST['necessidades']) ? implode(', ', $_POST['necessidades']) : '';

    // Salva no banco
    $sql = "INSERT INTO orcamentos 
            (nome, email, telefone, endereco, tipoImovel, tipoServico, area, urgencia, necessidades, observacoes)
            VALUES (:nome, :email, :telefone, :endereco, :tipoImovel, :tipoServico, :area, :urgencia, :necessidades, :observacoes)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':telefone' => $telefone,
        ':endereco' => $endereco,
        ':tipoImovel' => $tipoImovel,
        ':tipoServico' => $tipoServico,
        ':area' => $area,
        ':urgencia' => $urgencia,
        ':necessidades' => $necessidades,
        ':observacoes' => $observacoes
    ]);

    // Monta mensagem para WhatsApp
    $mensagem  = "*Pedido de Orçamento*\n";
    $mensagem .= "*Nome:* $nome\n";
    $mensagem .= "*Email:* $email\n";
    $mensagem .= "*Telefone:* $telefone\n";
    $mensagem .= "*Endereço da Obra:* $endereco\n";
    $mensagem .= "*Tipo de Imóvel:* $tipoImovel\n";
    $mensagem .= "*Tipo de Serviço:* $tipoServico\n";
    $mensagem .= "*Área Aproximada:* " . ($area ?: 'Não informado') . "\n";
    $mensagem .= "*Urgência:* " . ($urgencia ?: 'Não informado') . "\n";
    $mensagem .= "*Necessidades Adicionais:* " . ($necessidades ?: 'Nenhuma') . "\n";
    $mensagem .= "*Observações:* " . ($observacoes ?: 'Nenhuma') . "\n";

    echo json_encode([
        'success' => true,
        'mensagem' => $mensagem
    ]);
    exit;

} catch (\PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    exit;
}

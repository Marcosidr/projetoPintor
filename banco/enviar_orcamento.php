<?php
header('Content-Type: application/json');
require 'config.php';

try {
    // Salva os dados brutos recebidos em um arquivo de debug
    $logFile = __DIR__ . '/debug.txt';
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - POST: " . print_r($_POST, true) . PHP_EOL, FILE_APPEND);

    // Captura e trata os dados
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $tipoImovel = $_POST['tipoImovel'] ?? '';
    $tipoServico = $_POST['tipoServico'] ?? '';
    $area = isset($_POST['area']) && $_POST['area'] !== '' ? $_POST['area'] : null;
    $urgencia = $_POST['urgencia'] ?? '';
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
    $mensagem = "*Pedido de Orçamento*\n";
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

} catch (\PDOException $e) {
    // Registra erro no debug também
    file_put_contents($logFile, "ERRO PDO: " . $e->getMessage() . PHP_EOL, FILE_APPEND);

    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} catch (\Exception $e) {
    file_put_contents($logFile, "ERRO GERAL: " . $e->getMessage() . PHP_EOL, FILE_APPEND);

    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

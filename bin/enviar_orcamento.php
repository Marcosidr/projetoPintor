<?php
header('Content-Type: application/json');
require __DIR__ . '/config.php';
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

try {
    if (!isset($pdo) || !($pdo instanceof PDO)) {
        echo json_encode(['success' => false, 'error' => 'Conexão com o banco não configurada']);
        exit;
    }

    // captura POST
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $tipoImovel = $_POST['tipoImovel'] ?? '';
    $tipoServico = $_POST['tipoServico'] ?? '';
    $area = $_POST['area'] !== '' ? $_POST['area'] : null;
    $urgencia = $_POST['urgencia'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';
    $necessidades = isset($_POST['necessidades']) ? implode(', ', $_POST['necessidades']) : '';

    $sql = "INSERT INTO orcamentos 
            (nome, email, telefone, endereco, tipoImovel, tipoServico, area, urgencia, necessidades, observacoes)
            VALUES (:nome, :email, :telefone, :endereco, :tipoImovel, :tipoServico, :area, :urgencia, :necessidades, :observacoes)";
    $stmt = $pdo->prepare($sql);
    $ok = $stmt->execute([
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

    if (!$ok) {
        echo json_encode(['success' => false, 'error' => 'Erro ao inserir no banco']);
        exit;
    }

    echo json_encode(['success' => true, 'mensagem' => 'Orçamento gravado com sucesso']);
    exit;

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Erro no servidor']);
    exit;
}

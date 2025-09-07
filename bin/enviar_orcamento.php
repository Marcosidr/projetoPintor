<?php
header('Content-Type: application/json');
require 'config.php';
require __DIR__ . '/../vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
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

    // Pasta de logs
    $logDir = __DIR__ . '/../logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }
    $logFile = $logDir . '/orcamentos.log';

    // Grava log
    $log = date("Y-m-d H:i:s") .
        " | Nome: $nome | Email: $email | Telefone: $telefone" .
        " | Endereço: $endereco | Tipo Imóvel: $tipoImovel | Tipo Serviço: $tipoServico" .
        " | Área: " . ($area ?: 'N/I') .
        " | Urgência: " . ($urgencia ?: 'N/I') .
        " | Necessidades: " . ($necessidades ?: 'Nenhuma') .
        " | Obs: " . ($observacoes ?: 'Nenhuma') . "\n";

    file_put_contents($logFile, $log, FILE_APPEND);

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

    // Monta mensagem
    $mensagem = "Novo Pedido de Orçamento\n\n";
    $mensagem .= "Nome: $nome\n";
    $mensagem .= "Email: $email\n";
    $mensagem .= "Telefone: $telefone\n";
    $mensagem .= "Endereço da Obra: $endereco\n";
    $mensagem .= "Tipo de Imóvel: $tipoImovel\n";
    $mensagem .= "Tipo de Serviço: $tipoServico\n";
    $mensagem .= "Área Aproximada: " . ($area ?: 'Não informado') . "\n";
    $mensagem .= "Urgência: " . ($urgencia ?: 'Não informado') . "\n";
    $mensagem .= "Necessidades Adicionais: " . ($necessidades ?: 'Nenhuma') . "\n";
    $mensagem .= "Observações: " . ($observacoes ?: 'Nenhuma') . "\n";

    // Envio com PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'marcosincio556@gmail.com'; // seu email
        $mail->Password = 'zgwuwfpqngfgnqvf'; // senha de app do Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('marcosincio556@gmail.com', 'CLPinturas');
        $mail->addAddress('marcosincio556@gmail.com', 'Marcos'); // destino

        $mail->isHTML(false);
        $mail->Subject = "Novo Orçamento - $nome";
        $mail->Body = $mensagem;

        $mail->send();
    } catch (Exception $e) {
        file_put_contents($logFile, "ERRO EMAIL: " . $mail->ErrorInfo . PHP_EOL, FILE_APPEND);
    }

    // Retorno JSON
    echo json_encode([
        'success' => true,
        'mensagem' => "✅ Orçamento enviado com sucesso! Em breve entraremos em contato."
    ]);

} catch (\PDOException $e) {
    file_put_contents($logFile, "ERRO PDO: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} catch (\Exception $e) {
    file_put_contents($logFile, "ERRO GERAL: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

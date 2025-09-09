<?php
// filepath: c:/xampp/htdocs/projetoPintor/admin/adicionar_user.php
session_start();
require_once __DIR__ . "/../bin/config.php";
header("Content-Type: application/json; charset=utf-8");

// Segurança: só admin pode acessar
if (empty($_SESSION["usuario"]) || $_SESSION["usuario"]["tipo"] !== "admin") {
    echo json_encode(["status" => "error", "msg" => "Acesso negado!"]);
    exit;
}

try {
    // Se for GET -> buscar usuário pelo ID
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        $stmt = $pdo->prepare("SELECT id, nome, email, tipo FROM usuarios WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode($user);
        } else {
            echo json_encode(["status" => "error", "msg" => "Usuário não encontrado"]);
        }
        exit;
    }

    // Se for POST -> adicionar ou editar
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id    = $_POST["id"] ?? "";
        $nome  = trim($_POST["nome"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $tipo  = $_POST["tipo"] ?? "cliente";
        $senha = $_POST["senha"] ?? "";

        if (empty($nome) || empty($email)) {
            echo json_encode(["status" => "error", "msg" => "Preencha todos os campos obrigatórios"]);
            exit;
        }

        if ($id) {
            // Editar usuário
            if (!empty($senha)) {
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo, senha = :senha WHERE id = :id");
                $stmt->execute([
                    "nome"  => $nome,
                    "email" => $email,
                    "tipo"  => $tipo,
                    "senha" => $hash,
                    "id"    => $id
                ]);
            } else {
                $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id");
                $stmt->execute([
                    "nome"  => $nome,
                    "email" => $email,
                    "tipo"  => $tipo,
                    "id"    => $id
                ]);
            }
            echo json_encode(["status" => "success", "msg" => "Usuário atualizado com sucesso"]);
        } else {
            // Adicionar usuário
            if (empty($senha)) {
                echo json_encode(["status" => "error", "msg" => "Informe a senha para criar usuário"]);
                exit;
            }

            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, tipo, senha, criado_em) VALUES (:nome, :email, :tipo, :senha, NOW())");
            $stmt->execute([
                "nome"  => $nome,
                "email" => $email,
                "tipo"  => $tipo,
                "senha" => $hash
            ]);

            echo json_encode(["status" => "success", "msg" => "Usuário adicionado com sucesso"]);
        }
        exit;
    }

    // Caso nenhum dos fluxos seja atendido
    echo json_encode(["status" => "error", "msg" => "Requisição inválida"]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "msg" => "Erro: " . $e->getMessage()]);
    exit;
}

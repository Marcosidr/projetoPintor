<?php
session_start();
require_once __DIR__ . "/classes/Logger.php";

$data = json_decode(file_get_contents("php://input"), true);
$acao   = $data["acao"]   ?? "Ação desconhecida";
$pagina = $data["pagina"] ?? "Página desconhecida";

Logger::registrar($acao, $pagina);

echo json_encode(["status" => "ok"]);

<?php
// registrar_log.php
$data = json_decode(file_get_contents("php://input"), true);

$acao   = $data["acao"] ?? "Ação desconhecida";
$pagina = $data["pagina"] ?? "Página desconhecida";
$ip     = $_SERVER["REMOTE_ADDR"] ?? "IP desconhecido";
$agent  = $_SERVER["HTTP_USER_AGENT"] ?? "Navegador desconhecido";
$dataHora = date("Y-m-d H:i:s");

// Caso futuramente tenha autenticação, você pode usar $_SESSION["usuario"]
$usuario = "visitante";

// Nível do log (aqui sempre INFO, mas pode ser ERROR/WARNING em outros casos)
$nivel = "INFO";

// Formato profissional de log
$linha = "[$dataHora] [$nivel] [IP: $ip] [User: $usuario] " .
         "Ação: \"$acao\" | Página: $pagina | Navegador: $agent" . PHP_EOL;

file_put_contents(__DIR__ . "/logs/orcamentos.log", $linha, FILE_APPEND);

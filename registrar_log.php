<?php
// registrar_log.php
$data = json_decode(file_get_contents("php://input"), true);

$acao   = $data["acao"] ?? "Ação desconhecida";
$pagina = $data["pagina"] ?? "Página desconhecida";
$ip     = $_SERVER["REMOTE_ADDR"] ?? "IP desconhecido";
$agent  = $_SERVER["HTTP_USER_AGENT"] ?? "Navegador desconhecido";
$dataHora = date("Y-m-d H:i:s");

// se eu quiser que futuramente tenha autenticação, posso usar $_SESSION["usuario"]
$usuario = "visitante";

// Nível do log (aqui sempre INFO, mas pode ser ERROR/WARNING em outros casos)
$nivel = "INFO";

// Formato de log padrão
$linha = "[$dataHora] [$nivel] [IP: $ip] [User: $usuario] " .
         "Ação: \"$acao\" | Página: $pagina | Navegador: $agent" . PHP_EOL;

file_put_contents(__DIR__ . "/logs/sistema.log", $linha, FILE_APPEND);

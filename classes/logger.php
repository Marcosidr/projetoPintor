<?php
class Logger {
    public static function registrar($acao, $nivel = "INFO", $pagina = null) {
        require __DIR__ . "/../bin/config.php";

        $ip        = $_SERVER["REMOTE_ADDR"] ?? "IP desconhecido";
        $navegador = $_SERVER["HTTP_USER_AGENT"] ?? "Navegador desconhecido";
        $usuario   = $_SESSION["usuario"]["email"] ?? "visitante";
        $datahora  = date("Y-m-d H:i:s");

        try {
            $sql = "INSERT INTO logs (datahora, nivel, usuario, ip, acao, pagina, navegador)
                    VALUES (:datahora, :nivel, :usuario, :ip, :acao, :pagina, :navegador)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":datahora"  => $datahora,
                ":nivel"     => $nivel,
                ":usuario"   => $usuario,
                ":ip"        => $ip,
                ":acao"      => $acao,
                ":pagina"    => $pagina,
                ":navegador" => $navegador
            ]);
        } catch (Exception $e) {
            // Se banco falhar, salva fallback
            $linha = "[$datahora] ERRO LOG DB: " . $e->getMessage() . " | Ação: $acao" . PHP_EOL;
            file_put_contents(__DIR__ . "/../logs/fallback.log", $linha, FILE_APPEND);
        }
    }
}

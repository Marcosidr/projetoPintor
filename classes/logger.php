<?php
class Logger {
    private static $pdo;

    // Inicia conexão (recebe PDO de config.php)
    public static function init($pdo) {
        self::$pdo = $pdo;
    }

    /**
     * Registra log no banco
     * 
     * @param string $acao   → descrição do evento
     * @param string $pagina → arquivo/script onde ocorreu
     * @param string $nivel  → nível de log (INFO, ERRO, WARNING...)
     */
    public static function registrar($acao, $pagina = null, $nivel = "INFO") {
        if (!self::$pdo) {
            throw new Exception("Logger não inicializado. Chame Logger::init(\$pdo).");
        }

        $dataHora = date("Y-m-d H:i:s");
        $ip       = $_SERVER["REMOTE_ADDR"] ?? "IP desconhecido";
        $agent    = $_SERVER["HTTP_USER_AGENT"] ?? "Navegador desconhecido";
        $usuario  = $_SESSION["usuario"]["email"] ?? "visitante";

        try {
            $sql = "INSERT INTO logs (datahora, nivel, usuario, ip, acao, pagina, navegador)
                    VALUES (:datahora, :nivel, :usuario, :ip, :acao, :pagina, :navegador)";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([
                ":datahora"  => $dataHora,
                ":nivel"     => $nivel,
                ":usuario"   => $usuario,
                ":ip"        => $ip,
                ":acao"      => $acao,
                ":pagina"    => $pagina,
                ":navegador" => $agent
            ]);
        } catch (Exception $e) {
            // fallback em caso de erro: salva em arquivo
            file_put_contents(__DIR__ . "/../logs/fallback.log",
                "[".$dataHora."] ERRO LOG DB: ".$e->getMessage().PHP_EOL,
                FILE_APPEND
            );
        }
    }
}

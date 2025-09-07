<?php
session_start();
require_once __DIR__ . "/../classes/logger.php";

if (!empty($_SESSION["usuario"])) {
    $nome  = $_SESSION["usuario"]["nome"];
    $email = $_SESSION["usuario"]["email"];
    Logger::registrar("Logout realizado por: $email ($nome)", "INFO", "logout.php");
}

session_destroy();
header("Location: ../index.php");
exit;

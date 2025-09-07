<?php
session_start();
require_once __DIR__ . "/../classes/Logger.php";

if (!empty($_SESSION["usuario"])) {
    $nome  = $_SESSION["usuario"]["nome"];
    $email = $_SESSION["usuario"]["email"];
    Logger::registrar("LOGOUT OK: {$email} ({$nome})", "logout.php");
}

session_destroy();
header("Location: ../index.php");
exit;

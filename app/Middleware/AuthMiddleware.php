<?php
class AuthMiddleware
{
    public static function requireLogin()
    {
        session_start();
        if (empty($_SESSION['usuario'])) {
            header("Location: /login");
            exit;
        }
    }

    public static function requireAdmin()
    {
        session_start();
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
            header("Location: /painel");
            exit;
        }
    }
}

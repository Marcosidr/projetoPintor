<?php

class AuthController
{
    public function login()
    {
        view('auth/login');
    }

    public function register()
    {
        view('auth/register');
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: /login");
        exit;
    }
}

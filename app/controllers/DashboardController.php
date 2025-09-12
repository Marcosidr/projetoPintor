<?php
require_once ROOT_PATH . 'app/Middleware/AuthMiddleware.php';

class DashboardController
{
    public function index()
    {
        AuthMiddleware::requireLogin();
        view('painel/dashboard');
    }
}

<?php
require_once ROOT_PATH . 'app/Middleware/AuthMiddleware.php';

class AdminController
{
    public function index()
    {
        AuthMiddleware::requireAdmin();
        view('admin/gerenciar');
    }
}

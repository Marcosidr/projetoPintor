<?php
namespace App\Core;

abstract class Controller {
    protected function view(string $path, array $data = []): void {
        extract($data);
        ob_start();
        require ROOT_PATH.'app/Views/'.$path.'.php';
        $content = ob_get_clean();
        require ROOT_PATH.'app/Views/layouts/main.php';
    }

    protected function redirect(string $to): void {
        header('Location: '.BASE_URL.$to);
        exit;
    }
}

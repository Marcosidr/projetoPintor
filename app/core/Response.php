<?php
namespace App\Core;

class Response {
    public static function redirect(string $location): void {
        header('Location: ' . $location);
        exit;
    }
}

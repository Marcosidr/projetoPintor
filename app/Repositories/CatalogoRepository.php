<?php
namespace App\Repositories;

use CatalogoItem; // classe ainda sem namespace

class CatalogoRepository {
    /** @return CatalogoItem[] */
    public function all(): array {
        if (!class_exists('CatalogoManager')) {
            require_once ROOT_PATH . 'app/Models/CatalogoManager.php';
        }
        return \CatalogoManager::getItens();
    }
}

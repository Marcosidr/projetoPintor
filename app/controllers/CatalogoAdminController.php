<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\CatalogoRepository;

class CatalogoAdminController extends Controller
{
    private CatalogoRepository $repo;

    public function __construct()
    {
        $this->repo = new CatalogoRepository();
    }

    public function index(): void
    {
        $itens = $this->repo->all();
        $this->view('catalogos/admin', compact('itens'));
    }

    public function store(): void
    {
        if (!isset($_POST['titulo'], $_FILES['arquivo'])) {
            $_SESSION['flash_error'] = 'Dados incompletos';
            $this->redirect('/admin/catalogos');
            return;
        }
            if (!\App\Core\Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF'); }
        $titulo = trim($_POST['titulo']);
        if ($titulo === '' || mb_strlen($titulo) > 160) {
            $_SESSION['flash_error'] = 'Título inválido';
            $this->redirect('/admin/catalogos');
            return;
        }
        $file = $_FILES['arquivo'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['flash_error'] = 'Erro no upload';
            $this->redirect('/admin/catalogos');
            return;
        }
        // Validação básica
        $allowedExt = ['pdf','png','jpg','jpeg'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt, true)) {
            $_SESSION['flash_error'] = 'Extensão não permitida';
            $this->redirect('/admin/catalogos');
            return;
        }
        if ($file['size'] > $maxSize) {
            $_SESSION['flash_error'] = 'Arquivo muito grande';
            $this->redirect('/admin/catalogos');
            return;
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        $allowedMime = ['application/pdf','image/png','image/jpeg'];
        if (!in_array($mime, $allowedMime, true)) {
            $_SESSION['flash_error'] = 'MIME inválido';
            $this->redirect('/admin/catalogos');
            return;
        }
        $destDir = ROOT_PATH . 'public/uploads/catalogo/';
        if (!is_dir($destDir)) {
            mkdir($destDir, 0775, true);
        }
        $safeBase = preg_replace('/[^a-zA-Z0-9-_]/','_', pathinfo($file['name'], PATHINFO_FILENAME));
        $finalName = $safeBase . '_' . time() . '.' . $ext;
        $destPath = $destDir . $finalName;
        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            $_SESSION['flash_error'] = 'Falha ao mover arquivo';
            $this->redirect('/admin/catalogos');
            return;
        }
        $this->repo->create([
            'titulo' => $titulo,
            'arquivo' => $finalName,
        ]);
        $_SESSION['flash_success'] = 'Catálogo adicionado';
        $this->redirect('/admin/catalogos');
    }

    public function delete(int $id): void
    {
        $item = $this->repo->find($id);
        if ($item) {
                if (!\App\Core\Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF'); }
            $path = ROOT_PATH . 'public/uploads/catalogo/' . $item['arquivo'];
            $this->repo->delete($id);
            if (is_file($path)) @unlink($path);
            $_SESSION['flash_success'] = 'Removido';
        }
        $this->redirect('/admin/catalogos');
    }
}
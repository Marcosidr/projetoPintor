<?php
namespace App\Controllers;

use App\Core\Controller;

class QuemSomosController extends Controller
{
    public function index(): void
    {
        $this->view('quem_somos/index');
    }
}

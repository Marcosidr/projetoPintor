<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index');
    }

    public function about(): void
    {
        $this->view('quem_somos/index');
    }
}

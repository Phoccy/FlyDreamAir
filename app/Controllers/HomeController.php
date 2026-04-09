<?php
declare(strict_types=1);

namespace App\Controllers;

use Sys\Core\Controller;

final class HomeController extends Controller
{
    public function index(): void
    {
        $data = [];
        $this->display('Home/Index', $data);
    }
}
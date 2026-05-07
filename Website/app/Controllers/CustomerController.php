<?php
declare(strict_types=1);

namespace App\Controllers;

use Sys\Core\Controller;
use Sys\Library\Response;

final class CustomerController extends Controller
{
    public function index(): Response
    {
        $data = [];
        return $this->render('Pages/Customer/Dashboard', $data);

    }

    public function login(): Response
    {
        $data = [];
        return $this->render('Pages/Customer/Login', $data);
    }

}
<?php
declare(strict_types=1);

namespace App\Controllers;

use Sys\Core\Controller;
use Sys\Library\Response;

final class HomeController extends Controller
{
    public function index(): Response
    {
        $this->document->setTitle("FlyDreamAir | Lounge Management System");
        $this->document->setDescription("A lounge management system for FlyDreamAir customers");
        $this->document->addStyle("/assets/css/variables.css");
        $this->document->addStyle("/assets/css/default.css");
        

        $data = [
            'page' => [
                'title' => 'FlyDreamAir',
                'subtitle' => 'Premium Lounge Management System'
            ]
        ];
        return $this->render('Pages/Home/Index', $data);
    }
}
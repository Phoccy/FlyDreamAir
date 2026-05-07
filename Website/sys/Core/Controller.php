<?php
declare(strict_types=1);

namespace Sys\Core;

use Sys\Library\Document;
use Sys\Library\Response;

abstract class Controller
{
    public function __construct(protected readonly Registry $registry) {}

    public function __get(string $key): mixed
    {
        return $this->registry->$key;
    }



    protected function render(string $template, array $data = [], ?string $layout = 'Layouts/Default'): Response
    {
        return $this->registry->view->render($template, $data, $layout);
    }
}
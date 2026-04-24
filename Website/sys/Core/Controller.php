<?php
declare(strict_types=1);

namespace Sys\Core;

abstract class Controller
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View();
        $this->view->set(
            'head', ['title' => 'Planner']
        );
    }

    protected function display(string $page, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->view->set($key, $value);
        }

        $content = $this->view->render("pages/{$page}");

        $this->view->set('content', $content);
        echo $this->view->render('layouts/main');
    }
}
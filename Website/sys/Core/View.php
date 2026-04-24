<?php
declare(strict_types=1);

namespace Sys\Core;

use Exception;

final class View 
{
    private array $variables = [];

    public function set(string $key, mixed $value): self
    {
        $this->variables[$key] = $value;
        return $this;
    }

    public function render(string $path): string
    {
        extract($this->variables);

        $segments = explode('/', $path);

        $normalizedSegments = array_map(function($s) {
            $parts = explode('-', $s);
            return implode('-', array_map('ucfirst', $parts));
        }, $segments);

        $path = implode(DS, $normalizedSegments);
        $file = APP_PATH . DS . 'Views' . DS . $path . '.phtml';

        if (!file_exists($file)) throw new Exception("View not found: {$file}");

        ob_start();
        require $file;
        return (string) ob_get_clean();
    }

    public function component(string $name, array $data = []): string
    {
        $component = new self();
        foreach ($data as $key => $value) $component->set($key, $value);

        return $component->render("components/{$name}");
    } 
}
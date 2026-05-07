<?php
declare(strict_types=1);

namespace Sys\Core;

use RuntimeException;
use Sys\Library\Document;
use Sys\Library\Response;

final class View 
{
    private array $sections = [];
    private ?string $currentSection = null;

    public function __construct(private readonly string $viewsPath, private readonly Document $document) {}

    public function render(string $template, array $data = [], ?string $layout = 'Layouts/Default'): Response
    {
        $this->sections = [];
        $this->currentSection = null;

        $content = $this->renderFile($template, $data);

        if ($layout !== null) {
            $content = $this->renderFile($layout, array_merge($data, ['content' => $content, 'document' => $this->document]));
        }

        return new Response($content);
    }

    public function partial(string $template, array $data = []): string 
    {
        return $this->renderFile($template, $data);
    }

    public function component(string $name, array $data = []): string
    {
        return $this->renderFile('Components/' . $this->normalizeViewName($name), $data);
    }

    public function common(string $name, array $data = []): string 
    {
        return $this->renderFile('Common/' . $this->normalizeViewName($name), $data);
    }

    public function startSection(string $name): void
    {
        if ($this->currentSection !== null) {
            throw new RuntimeException('A section is already open.');
        }

        $this->currentSection = $name;
        ob_start();
    }

    public function endSection(): void
    {
        if ($this->currentSection === null) {
            throw new RuntimeException('No section open.');
        }

        $this->sections[$this->currentSection] = (string) ob_get_clean();
        $this->currentSection = null;
    }

    public function section(string $name, string $default = ''): string
    {
        return $this->sections[$name] ?? $default;
    }

    public function hasSection(string $name): bool
    {
        return isset($this->sections[$name]) && $this->sections[$name] !== '';
    }

    private function renderFile(string $template, array $data = []): string
    {
        $path = $this->resolvePath($template);

        if (!is_file($path)) {
            throw new RuntimeException(sprintf('View [%s] not found at [%s].', $template, $path));
        }

        $view = $this;
        $document = $this->document;

        extract($data, EXTR_SKIP);

        ob_start();

        try {
            include $path;            
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }

        return (string) ob_get_clean();
    }

    private function resolvePath(string $template): string
    {
        $template = str_replace(['/', '\\'], DS, trim($template, '/\\'));

        return rtrim($this->viewsPath, '/\\') . DS . $template . '.phtml';
    }    

    private function normalizeViewName(string $name): string
    {
        $name = trim($name);

        if ($name === '') {
            throw new RuntimeException('View name cannot be empty.');
        }

        $segments = preg_split('#[\\/]+#', $name) ?: [];

        $segments = array_map(function (string $segment): string {
            $parts = explode('-', $segment);
            $parts = array_map(static fn(string $part): string => ucfirst($part), $parts);

            return implode('-', $parts);
        }, $segments);

        return implode('/', $segments);
    }    
}
<?php
declare(strict_types=1);

namespace Sys\Library;

final class Document
{
    private string $title = '';
    private string $description = '';
    private string $theme = '';
    private array $styles = [];
    private array $scripts = [];

    public function setTitle(string $title): self
    {
        $this->title = trim($title);
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription(string $description): self 
    {
        $this->description = trim($description);
        return $this;
    }

    public function getDescription(): string 
    {
        return $this->description;
    }

    public function addStyle(string $href): self 
    {
        if (!in_array($href, $this->styles, true)) {
            $this->styles[] = $href;
        }

        return $this;
    }

    public function getStyles(): array 
    {
        return $this->styles;
    }

    public function addScript(string $src): self
    {
        if (!in_array($src, $this->scripts, true)) {
            $this->scripts[] = $src;            
        }

        return $this;
    }

    public function getScripts(): array
    {
        return $this->scripts;
    }
}
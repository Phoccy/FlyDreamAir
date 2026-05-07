<?php
declare(strict_types=1);

namespace Sys\Library;

class Response
{
    protected array $headers = [];
    protected int $statusCode = 200;

    public function __construct(
        protected string $content = ''
    ) {}

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function setHeader(string $name, string $value): static
    {
        $this->headers[$name] = $value;

        return $this;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value, true);
        }

        echo $this->content;
    }
}
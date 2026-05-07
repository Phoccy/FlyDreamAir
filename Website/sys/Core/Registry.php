<?php
declare(strict_types=1);

namespace Sys\Core;

use BadFunctionCallException;

final class Registry
{
    private array $data = [];
    public function add(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function __get(string $key): mixed 
    {
        if (isset($this->data[$key])) {
            if ($this->data[$key] instanceof \Closure) {
                $this->data[$key] = $this->data[$key]($this);
            }
            return $this->data[$key];
        }
        throw new BadFunctionCallException(sprintf('Key (%s) is not registered.', $key));
    }
}
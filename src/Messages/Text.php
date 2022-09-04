<?php

namespace Spatie\DiscordAlerts\Messages;

class Text implements Message
{
    protected string $fields;

    public function getHeaders(): array
    {
        return [
            'Content-Type' => $this->getContentType(),
            'Content-Length' => strlen((string) $this),
        ];
    }

    public function getContentType(): string
    {
        return 'application/json';
    }

    public function add(...$fields): self
    {
        $this->fields = $fields[0];

        return $this;
    }

    function __toString(): string
    {
        return $this->fields;
    }
}

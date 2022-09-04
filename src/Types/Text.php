<?php

namespace Spatie\DiscordAlerts\Types;

class Text extends Message
{
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

    function __toString()
    {
        return json_encode($this->fields);
    }
}

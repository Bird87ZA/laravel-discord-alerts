<?php

namespace Spatie\DiscordAlerts\Types;

abstract class Message
{
    protected array $fields = [];

    abstract function getHeaders();

    abstract function getContentType();

    abstract function __toString();

    public function add(...$fields): self
    {
        foreach ($fields as $field) {
            $this->fields[] = $field;
        }

        return $this;
    }
}

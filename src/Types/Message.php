<?php

namespace Spatie\DiscordAlerts\Types;

interface Message
{
    public function getHeaders(): array;

    public function getContentType(): string;

    public function __toString(): string;

    public function add(...$fields): self;
}

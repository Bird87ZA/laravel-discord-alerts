<?php

namespace Spatie\DiscordAlerts\Messages;

interface Message extends \Stringable
{
    public function getHeaders(): array;

    public function getContentType(): string;

    public function add(...$fields): self;
}

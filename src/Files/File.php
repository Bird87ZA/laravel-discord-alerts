<?php

namespace Spatie\DiscordAlerts\Files;

interface File extends \Stringable
{
    public function getName(): string;
    public function getFilename(): string;
}

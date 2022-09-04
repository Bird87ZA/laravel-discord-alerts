<?php

namespace Spatie\DiscordAlerts\Files;

interface File extends \Stringable
{
    public function getFilename(): string;
    public function getMimeType(): string;
}

<?php

namespace Spatie\DiscordAlerts\Files;

use Illuminate\Contracts\Support\Arrayable;

interface File extends \Stringable, Arrayable
{
    public function getFilename(): string;
    public function getMimeType(): string;
}

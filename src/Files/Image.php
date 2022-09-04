<?php

namespace Spatie\DiscordAlerts\Files;

class Image implements File
{
    public function __construct(
        protected string $filePath
    ) {
    }

    public function getName(): string
    {
        return pathinfo($this->filePath, PATHINFO_FILENAME);
    }

    public function getFilename(): string
    {
        return pathinfo($this->filePath, PATHINFO_FILENAME) . '.' . pathinfo($this->filePath, PATHINFO_EXTENSION);
    }

    public function __toString(): string
    {
        return base64_encode(file_get_contents($this->filePath));
    }
}

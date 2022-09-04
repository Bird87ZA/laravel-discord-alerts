<?php

namespace Spatie\DiscordAlerts\Files;

use function _PHPStan_1a8f07040\RingCentral\Psr7\mimetype_from_filename;

class Image implements File
{
    public function __construct(
        protected string $filePath
    ) {
    }

    public function getFilename(): string
    {
        return pathinfo($this->filePath, PATHINFO_FILENAME) . '.' . pathinfo($this->filePath, PATHINFO_EXTENSION);
    }

    public function getMimeType(): string
    {
        return mimetype_from_filename($this->filePath);
    }

    public function toArray(): array
    {
        return [
            'title' => $this->getFilename(),
            'image' => [
                'url' => sprintf('attachment://%s', $this->getFilename())
            ]
        ];
    }

    public function __toString(): string
    {
        return base64_encode(file_get_contents($this->filePath));
    }
}

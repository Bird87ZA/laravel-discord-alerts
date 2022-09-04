<?php

namespace Spatie\DiscordAlerts\Messages;

use Spatie\DiscordAlerts\Files\File;

class Multipart implements Message
{
    protected array $fields = [];
    protected string $boundary;

    public function __construct(array $fields = [], string $boundary = null)
    {
        $this->fields = $fields;
        $this->boundary = $boundary ?? '-----spatie-message-boundary';
    }

    public function add(...$fields): self
    {
        foreach ($fields as $field) {
            $this->fields[] = $field;
        }

        return $this;
    }

    public function getHeaders(): array
    {
        return [
            'Content-Type' => $this->getContentType(),
            'Content-Length' => strlen((string) $this),
        ];
    }

    public function getContentType(): string
    {
        return 'multipart/form-data; boundary='.substr($this->boundary, 2);
    }

    public function __toString(): string
    {
        $body = $this->boundary . PHP_EOL;
        $body .= 'Content-Disposition: form-data; name="payload_json"' . PHP_EOL;
        $body .= 'Content-Type: application/json' . PHP_EOL;
        $body .= json_encode($this->fields) . PHP_EOL;
        $body .= $this->boundary . PHP_EOL;

        /** @var File $field */
        foreach ($this->fields as $key => $field) {
            $body .= sprintf('Content-Disposition: form-data; name="files[%d]"; filename="%s"', $key, $field->getFilename());
            $body .= sprintf('Content-Type: %s', $field->getMimeType());
            $body .= $field . PHP_EOL;
            $body .= $this->boundary . PHP_EOL;
        }

        $body .= $this->boundary . "--" . PHP_EOL;

        return $body;
    }
}

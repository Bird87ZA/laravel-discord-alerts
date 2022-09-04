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
        $body = '';

        /** @var File $field */
        foreach ($this->fields as $field) {
            $body .= $this->boundary."\n";
            $body .= sprintf("Content-Disposition: form-data; name=%s; filename=%s", $field->getName(), $field->getFilename());

            $body .= "\n";

//            if (isset($field['headers'])) {
//                foreach ($field['headers'] as $header => $value) {
//                    $body .= $header.': '.$value."\n";
//                }
//            }

            $body .= "\n" . $field . "\n";
        }

        $body .= $this->boundary . "--\n";

        return $body;
    }
}

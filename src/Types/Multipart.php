<?php

namespace Spatie\DiscordAlerts\Types;

class Multipart extends Message
{
    protected string $boundary;

    public function __construct(array $fields = [], string $boundary = null)
    {
        $this->fields = $fields;
        $this->boundary = $boundary ?? '-----spatie-message-boundary';
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

        foreach ($this->fields as $field) {
            $body .= $this->boundary."\n";
            $body .= "Content-Disposition: form-data; name={$field['name']}";

            if (isset($field['filename'])) {
                $body .= "; filename={$field['filename']}";
            }

            $body .= "\n";

            if (isset($field['headers'])) {
                foreach ($field['headers'] as $header => $value) {
                    $body .= $header.': '.$value."\n";
                }
            }

            $body .= "\n".$field['content']."\n";
        }

        $body .= $this->boundary."--\n";

        return $body;
    }
}

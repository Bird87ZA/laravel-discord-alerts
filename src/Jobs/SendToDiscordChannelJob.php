<?php

namespace Spatie\DiscordAlerts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Spatie\DiscordAlerts\Types\Message;

class SendToDiscordChannelJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     */
    public int $maxExceptions = 3;

    public function __construct(
        public Message $message,
        public string $webhookUrl
    ) {
    }

    public function handle(): void
    {
        $payload = [
            'content' => (string) $this->message,
        ];

        Http::withHeaders($this->message->getHeaders())->post($this->webhookUrl, $payload);
    }
}

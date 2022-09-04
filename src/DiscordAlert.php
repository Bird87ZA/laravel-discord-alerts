<?php

namespace Spatie\DiscordAlerts;

use Illuminate\Http\Exceptions\PostTooLargeException;
use PhpParser\Node\Expr\AssignOp\Mul;
use Spatie\DiscordAlerts\Messages\Multipart;
use Spatie\DiscordAlerts\Messages\Text;

class DiscordAlert
{
    protected string $webhookUrlName = 'default';
    protected array $embeds = [];

    public function to(string $webhookUrlName): self
    {
        $this->webhookUrlName = $webhookUrlName;

        return $this;
    }

    public function embed(...$embeds): self
    {
        foreach ($embeds as $embed) {
            if (count($this->embeds) >= 10) {
                throw new PostTooLargeException('You can only have 10 embeds per message.');
            }

            $this->embeds[] = $embed;
        }

        return $this;
    }

    public function message(string $text): void
    {
        $webhookUrl = Config::getWebhookUrl($this->webhookUrlName);

        if (empty($this->embeds)) {
            $message = (new Text())
                ->add($text);
        } else {
            $message = (new Multipart())
                ->add($text)
                ->add($this->embeds);
        }

        $jobArguments = [
            'message' => $message,
            'webhookUrl' => $webhookUrl,
        ];

        $job = Config::getJob($jobArguments);

        dispatch($job);
    }
}

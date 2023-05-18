<?php declare(strict_types=1);

namespace NewsFeed\Core;

class TwigView
{
    private string $template;
    private array $response;

    public function __construct(string $template, array $response)
    {
        $this->template = $template;
        $this->response = $response;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getResponse(): array
    {
        return $this->response;
    }
}
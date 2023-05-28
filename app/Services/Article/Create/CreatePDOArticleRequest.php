<?php declare(strict_types=1);

namespace NewsFeed\Services\Article\Create;

class CreatePDOArticleRequest
{
    private string $title;
    private string $body;
    private int $userId;

    public function __construct(int $userId, string $title, string $body)
        {
            $this->title = $title;
            $this->body = $body;
            $this->userId = $userId;
        }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

}
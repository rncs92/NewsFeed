<?php declare(strict_types=1);

namespace NewsFeed\Services\Article\Edit;

class EditPDOArticleRequest
{
    private string $title;
    private string $body;
    private int $userId;
    private int $postId;

    public function __construct(int $userId, string $title, string $body, int $postId)
    {
        $this->title = $title;
        $this->body = $body;
        $this->userId = $userId;
        $this->postId = $postId;
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

    public function getPostId(): int
    {
        return $this->postId;
    }
}
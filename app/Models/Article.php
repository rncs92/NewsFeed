<?php

namespace NewsFeed\Models;

class Article
{
    private int $userID;
    private int $postID;
    private string $title;
    private string $body;
    private ?User $user = null;

    public function __construct(int $userID, int $postID, string $title, string $body)
    {

        $this->userID = $userID;
        $this->postID = $postID;
        $this->title = $title;
        $this->body = $body;
    }

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function getPostID(): int
    {
        return $this->postID;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
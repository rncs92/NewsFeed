<?php

namespace NewsFeed\Models;

use Carbon\Carbon;

class Article
{
    private int $userID;
    private string $title;
    private string $body;
    private ?User $user = null;
    private string $createdAt;

    private ?int $postID;

    public function __construct(int $userID, string $title, string $body, string $createdAt = null, int $postID = null)
    {

        $this->userID = $userID;
        $this->title = $title;
        $this->body = $body;
        $this->createdAt = $createdAt ?? Carbon::now()->toAtomString();
        $this->postID = $postID;
    }

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function getPostID(): ?int
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

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setPostID(?int $postID): void
    {
        $this->postID = $postID;
    }

    public function edit(array $attributes): void
    {
        foreach ($attributes as $attribute => $value) {
            $this->{$attribute} = $value;
        }
    }
}
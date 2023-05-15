<?php

namespace NewsFeed\Models;

class Post
{
    private int $userID;
    private int $postID;
    private string $title;
    private string $body;

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
}
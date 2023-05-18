<?php

namespace NewsFeed\Services\User\Show;

use NewsFeed\Models\User;

class ShowUserResponse
{
    private User $user;
    private array $article;

    public function __construct(User $user, array $articles)
    {
        $this->user = $user;
        $this->article = $articles;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getArticle(): array
    {
        return $this->article;
    }
}
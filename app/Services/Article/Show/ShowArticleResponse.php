<?php declare(strict_types=1);

namespace NewsFeed\Services\Article\Show;

use NewsFeed\Models\Article;

class ShowArticleResponse
{
    private Article $article;
    private array $comments;

    public function __construct(Article $article, array $comments)
    {
        $this->article = $article;
        $this->comments = $comments;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function getComments(): array
    {
        return $this->comments;
    }
}
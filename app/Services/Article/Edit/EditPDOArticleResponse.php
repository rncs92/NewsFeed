<?php declare(strict_types=1);

namespace NewsFeed\Services\Article\Edit;

use NewsFeed\Models\Article;

class EditPDOArticleResponse
{
    private Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }
}
<?php declare(strict_types=1);

namespace NewsFeed\Services\Article\Create;

use NewsFeed\Models\Article;

class CreatePDOArticleResponse
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
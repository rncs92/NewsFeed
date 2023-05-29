<?php declare(strict_types=1);

namespace NewsFeed\Services\Article\Delete;

use NewsFeed\Repository\Article\ArticleRepository;

class DeletePDOArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function handle(int $articleId): void
    {
        $this->articleRepository->delete($articleId);
    }
}

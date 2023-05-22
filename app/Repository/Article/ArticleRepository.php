<?php declare(strict_types=1);


namespace NewsFeed\Repository\Article;
use NewsFeed\Models\Article;

interface ArticleRepository
{
    public function fetchById(int $articleId): ?Article;

    public function createCollection(): array;

    public function createUserArticleCollection(int $userId): array;
}

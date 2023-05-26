<?php declare(strict_types=1);


namespace NewsFeed\Repository\Article;
use Carbon\Carbon;
use NewsFeed\Models\Article;

interface ArticleRepository
{
    public function fetchById(int $articleId): ?Article;

    public function createCollection(): array;

    public function createUserArticleCollection(int $userId): array;

    public function create(int $author, string $title, string $body, Carbon $createdAt): string;
    public function update(int $author, string $title, string $body, Carbon $createdAt): string;
    public function delete(int $author): string;
}

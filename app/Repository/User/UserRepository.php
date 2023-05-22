<?php declare(strict_types=1);


namespace NewsFeed\Repository\User;
use NewsFeed\Models\User;

interface UserRepository
{
    public function byId(int $userId): ?User;
    public function createCollection(): array;
}

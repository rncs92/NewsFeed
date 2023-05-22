<?php declare(strict_types=1);


namespace NewsFeed\Repository\Comment;
interface CommentRepository
{
    public function createCommentsCollection(int $postId): array;
}


<?php

namespace NewsFeed\Repository\Comment;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use NewsFeed\Cache;
use NewsFeed\Models\Comment;
use stdClass;

class JsonPlaceholderCommentRepository implements CommentRepository
{
    private Client $client;
    private const BASIC_API_URL = 'https://jsonplaceholder.typicode.com';

    public function __construct()
    {
        $this->client = new Client();
    }

    private function all(int $articleId = 1): array
    {
        try {
            if (!Cache::check('comments_' . $articleId)) {
                $response = $this->client->request('GET', self::BASIC_API_URL . "/comments?postId=$articleId");
                $rawData = $response->getBody()->getContents();
                Cache::set('comments_' . $articleId, $rawData);
            } else {
                $rawData = Cache::get('comments_' . $articleId);
            }
            return json_decode($rawData);
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function createCommentsCollection(int $postId): array
    {
        $comments = $this->all($postId);

        $commentsCollection = [];
        foreach ($comments as $comment) {
            $commentsCollection[] = $this->buildModel($comment);
        }
        return $commentsCollection;
    }

    private function buildModel(stdClass $comment): Comment
    {
        return new Comment(
            $comment->postId,
            $comment->id,
            $comment->name,
            $comment->email,
            $comment->body,
        );
    }
}
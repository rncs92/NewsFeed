<?php

namespace NewsFeed\Repository\Article;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use NewsFeed\Cache;
use NewsFeed\Models\Article;
use stdClass;

class JsonPlaceholderArticleRepository implements ArticleRepository
{
    private Client $client;
    private const BASIC_API_URL = 'https://jsonplaceholder.typicode.com';

    public function __construct()
    {
        $this->client = new Client();
    }

    private function all(): array
    {
        try {
            if (!Cache::check('posts')) {
                $response = $this->client->request('GET', self::BASIC_API_URL . '/posts');
                $rawData = $response->getBody()->getContents();
                Cache::set('posts', $rawData);
            } else {
                $rawData = Cache::get('posts');
            }
            return json_decode($rawData);
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchById(int $articleId): ?Article
    {
        try {
            if (!Cache::check('posts_' . $articleId)) {
                $response = $this->client->request('GET', self::BASIC_API_URL . "/posts/$articleId");
                $rawData = $response->getBody()->getContents();
                Cache::set('posts_' . $articleId, $rawData);
            } else {
                $rawData = Cache::get('posts_' . $articleId);
            }
            $post = json_decode($rawData);

            return $this->buildModel($post);
        } catch (GuzzleException $exception) {
            return null;
        }
    }

    private function fetchByUser(int $userId): array
    {
        try {
            if (!Cache::check('userPosts_' . $userId)) {
                $response = $this->client->request('GET', self::BASIC_API_URL . "/posts?userId=$userId");
                $rawData = $response->getBody()->getContents();
                Cache::set('userPosts_' . $userId, $rawData);
            } else {
                $rawData = Cache::get('userPosts_' . $userId);
            }
            return json_decode($rawData);
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function createCollection(): array
    {
        $posts = $this->all();

        $postsCollection = [];
        foreach ($posts as $post) {
            $postsCollection[] = $this->buildModel($post);
        }
        return $postsCollection;
    }

    public function createUserArticleCollection(int $userId): array
    {
        $userPosts = $this->fetchByUser($userId);

        $userPostsCollection = [];
        foreach ($userPosts as $post) {
            $userPostsCollection[] = $this->buildModel($post);
        }
        return $userPostsCollection;
    }

    private function buildModel(stdClass $post): Article
    {
        return new Article(
            $post->userId,
            $post->id,
            $post->title,
            $post->body,
        );
    }

    public function save(Article $article): void
    {
    }

    public function edit(Article $article): void
    {
    }

    public function update(Article $article): void
    {
    }

    public function delete(int $articleId): void
    {
    }
}
<?php declare(strict_types=1);

namespace NewsFeed;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use NewsFeed\Models\Comment;
use NewsFeed\Models\Article;
use NewsFeed\Models\User;
use stdClass;

class ApiClient
{

    private Client $client;
    private const BASIC_API_URL = 'https://jsonplaceholder.typicode.com/';

    public function __construct()
    {
        $this->client = new Client();
    }

    private function fetchArticles(): array
    {
        try {
            if (!Cache::check('posts')) {
                $response = $this->client->request('GET', self::BASIC_API_URL . 'posts');
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

    private function fetchUsers(): array
    {
        try {
            if (!Cache::check('users')) {
                $response = $this->client->request('GET', self::BASIC_API_URL . 'users');
                $rawData = $response->getBody()->getContents();
                Cache::set('users', $rawData);
            } else {
                $rawData = Cache::get('users');
            }

            return json_decode($rawData);
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchArticlesById(int $articleId): ?Article
    {
        try {
            if (!Cache::check('posts_' . $articleId)) {
                $response = $this->client->request('GET', self::BASIC_API_URL . "posts/$articleId");
                $rawData = $response->getBody()->getContents();
                Cache::set('posts_' . $articleId, $rawData);
            } else {
                $rawData = Cache::get('posts_' . $articleId);
            }
            $post = json_decode($rawData);

            return $this->createArticle($post);
        } catch (GuzzleException $exception) {
            return null;
        }
    }

    public function fetchArticlesByUser(int $userId): array
    {
        try {
            if (!Cache::check('userPosts_' . $userId)) {
                $response = $this->client->request('GET', self::BASIC_API_URL . "posts?userId=$userId");
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

    public function fetchUsersById(int $userId): ?User
    {
        try {
            if (!Cache::check('user_' . $userId)) {
                $response = $this->client->request('GET', self::BASIC_API_URL . "users/$userId");
                $rawData = $response->getBody()->getContents();
                Cache::set('user_' . $userId, $rawData);
            } else {
                $rawData = Cache::get('user_' . $userId);
            }
            $user = json_decode($rawData);

            return $this->createUser($user);
        } catch (GuzzleException $exception) {
            return null;
        }
    }

    private function getArticleComments(int $articleId = 1): array
    {
        try {
            if (!Cache::check('comments_' . $articleId)) {
                $response = $this->client->request('GET', self::BASIC_API_URL . "comments?postId=$articleId");
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

    public function createArticlesCollection(): array
    {
        $posts = $this->fetchArticles();

        $postsCollection = [];
        foreach ($posts as $post) {
            $postsCollection[] = $this->createArticle($post);
        }

        return $postsCollection;
    }

    public function createUsersCollection(): array
    {
        $users = $this->fetchUsers();

        $usersCollection = [];
        foreach ($users as $user) {
            $usersCollection[] = $this->createUser($user);
        }

        return $usersCollection;
    }

    public function createUserArticlesCollection($userId): array
    {
        $userPosts = $this->fetchArticlesByUser($userId);

        $userPostsCollection = [];
        foreach ($userPosts as $post) {
            $userPostsCollection[] = $this->createArticle($post);
        }

        return $userPostsCollection;
    }

    public function createCommentsCollection(int $postId): array
    {
        $comments = $this->getArticleComments($postId);

        $commentsCollection = [];
        foreach ($comments as $comment) {
            $commentsCollection[] = $this->createComment($comment);
        }

        return $commentsCollection;
    }

    private function createArticle(stdClass $post): Article
    {
        $id = $post->userId;

        return new Article(
            $post->userId,
            $post->id,
            $post->title,
            $post->body,
            $this->fetchUsersById($id)
        );
    }

    private function createComment(stdClass $comment): Comment
    {
        return new Comment(
            $comment->postId,
            $comment->id,
            $comment->name,
            $comment->email,
            $comment->body,
        );
    }

    private function createUser(stdClass $user): User
    {
        return new User(
            $user->id,
            $user->name,
            $user->username,
            $user->email,
            $user->address->street,
            $user->address->city,
            $user->company->name,
            $user->company->bs,
            $user->phone,
            $user->company->catchPhrase,
        );
    }
}
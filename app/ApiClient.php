<?php declare(strict_types=1);

namespace NewsFeed;

use GuzzleHttp\Client;
use NewsFeed\Models\Comment;
use NewsFeed\Models\Post;
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

    private function fetchPosts(): array
    {
        if (!Cache::check('posts')) {
            $response = $this->client->request('GET', self::BASIC_API_URL . 'posts');
            $rawData = $response->getBody()->getContents();
            Cache::set('posts', $rawData);
        } else {
            $rawData = Cache::get('posts');
        }

        return json_decode($rawData);
    }

    public function fetchPostById(int $id): Post
    {
        if (!Cache::check('posts_' . $id)) {
            $response = $this->client->request('GET', self::BASIC_API_URL . "posts/$id");
            $rawData = $response->getBody()->getContents();
            Cache::set('posts_' . $id, $rawData);
        } else {
            $rawData = Cache::get('posts_' . $id);
        }
        $post = json_decode($rawData);

        return $this->createPost($post);
    }

    public function fetchPostsByUser(int $userId): array
    {
        if (!Cache::check('userPosts_' . $userId)) {
            $response = $this->client->request('GET', self::BASIC_API_URL . "posts?userId=$userId");
            $rawData = $response->getBody()->getContents();
            Cache::set('userPosts_' . $userId, $rawData);
        } else {
            $rawData = Cache::get('userPosts_' . $userId);
        }
        return json_decode($rawData);
    }

    public function fetchUsersById(int $id): User
    {
        if (!Cache::check('user_' . $id)) {
            $response = $this->client->request('GET', self::BASIC_API_URL . "users/$id");
            $rawData = $response->getBody()->getContents();
            Cache::set('user_' . $id, $rawData);
        } else {
            $rawData = Cache::get('user_' . $id);
        }
        $user = json_decode($rawData);

        return $this->createUser($user);
    }

    private function getPostComments(int $postId = 1): array
    {
        if (!Cache::check('comments_' . $postId)) {
            $response = $this->client->request('GET', self::BASIC_API_URL . "comments?postId=$postId");
            $rawData = $response->getBody()->getContents();
            Cache::set('comments_' . $postId, $rawData);
        } else {
            $rawData = Cache::get('comments_' . $postId);
        }

        return json_decode($rawData);
    }

    public function createPostCollection(): array
    {
        $posts = $this->fetchPosts();

        $postsCollection = [];
        foreach ($posts as $post) {
            $postsCollection[] = $this->createPost($post);
        }

        return $postsCollection;
    }

    public function createUserPostCollection($userId): array
    {
        $userPosts = $this->fetchPostsByUser($userId);

        $userPostsCollection = [];
        foreach ($userPosts as $post) {
            $userPostsCollection[] = $this->createPost($post);
        }

        return $userPostsCollection;
    }

    public function createCommentsCollection(int $postId): array
    {
        $comments = $this->getPostComments($postId);

        $commentsCollection = [];
        foreach ($comments as $comment) {
            $commentsCollection[] = $this->createComment($comment);
        }

        return $commentsCollection;
    }

    private function createPost(stdClass $post): Post
    {
        $id = $post->userId;

        return new Post(
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
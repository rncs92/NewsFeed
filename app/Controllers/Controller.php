<?php

namespace NewsFeed\Controllers;

use NewsFeed\ApiClient;
use NewsFeed\TwigView;

class Controller
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function getPosts(): TwigView
    {
        $posts = $this->client->createPostCollection();

        return new TwigView('index', [
            'posts' => $posts,
        ]);
    }

    public function viewPost(array $vars): TwigView
    {
        $id = isset($vars['id']) ? (int)$vars['id'] : 1;
        $post = $this->client->fetchPostById($id);
        $comments = $this->client->createCommentsCollection($id);

        return new TwigView('post', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function getUsers(array $vars): TwigView
    {
        $id = isset($vars['id']) ? (int)$vars['id'] : 1;
        $user = $this->client->fetchUsersById($id);
        $userPosts = $this->client->createUserPostCollection($id);

        return new TwigView('user', [
            'user' => $user,
            'posts' => $userPosts
        ]);
    }
}
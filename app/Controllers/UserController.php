<?php declare(strict_types=1);

namespace NewsFeed\Controllers;

use NewsFeed\ApiClient;
use NewsFeed\Core\TwigView;

class UserController
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }
    public function show(array $vars): TwigView
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
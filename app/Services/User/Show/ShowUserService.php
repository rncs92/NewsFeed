<?php

namespace NewsFeed\Services\User\Show;

use NewsFeed\ApiClient;
use NewsFeed\Exceptions\ResourceNotFoundException;

class ShowUserService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function handle(ShowUserRequest $request): ShowUserResponse
    {
        $userId = $request->getUserId();
        $user = $this->client->fetchUsersById($userId);
        $userArticles = $this->client->createUserArticlesCollection($userId);

        if ($user == null) {
            throw new ResourceNotFoundException("User Nr. $userId not found!");
        }

        return new ShowUserResponse($user, $userArticles);
    }
}
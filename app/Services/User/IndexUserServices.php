<?php

namespace NewsFeed\Services\User;

use NewsFeed\ApiClient;
use NewsFeed\Exceptions\ResourceNotFoundException;

class IndexUserServices
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function handle(): array
    {
        try {
            return $this->client->createUsersCollection();
        } catch (ResourceNotFoundException $exception) {
            return [];
        }
    }
}
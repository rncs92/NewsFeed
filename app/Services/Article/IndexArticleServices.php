<?php

namespace NewsFeed\Services\Article;

use NewsFeed\ApiClient;
use NewsFeed\Exceptions\ResourceNotFoundException;

class IndexArticleServices
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function handle(): array
    {
        try {
            return $this->client->createArticlesCollection();
        } catch (ResourceNotFoundException $exception) {
            return [];
        }
    }
}
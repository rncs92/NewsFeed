<?php

namespace NewsFeed\Services\Article\Show;

use NewsFeed\ApiClient;
use NewsFeed\Exceptions\ResourceNotFoundException;

class ShowArticleServices
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function handle(ShowArticleRequest $request): ShowArticleResponse
    {
        $articleId = $request->getArticleId();
        $article = $this->client->fetchArticlesById($articleId);

        if ($article == null) {
            throw new ResourceNotFoundException("Article Nr.$articleId-> not found!");
        }

        $comments = $this->client->createCommentsCollection($articleId);

        return new ShowArticleResponse($article, $comments);
    }
}
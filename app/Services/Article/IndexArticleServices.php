<?php

namespace NewsFeed\Services\Article;

use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Models\Article;
use NewsFeed\Repository\Article\ArticleRepository;
use NewsFeed\Repository\Article\JsonPlaceholderArticleRepository;
use NewsFeed\Repository\User\JsonPlaceholderUserRepository;
use NewsFeed\Repository\User\UserRepository;

class IndexArticleServices
{
    private ArticleRepository $articleRepository;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->articleRepository = new JsonPlaceholderArticleRepository();
        $this->userRepository = new JsonPlaceholderUserRepository();
    }

    public function handle(): array
    {
        try {
            $articles =  $this->articleRepository->createCollection();


            foreach($articles as $article) {
                /** @var Article $article */
                $article->setUser($this->userRepository->byId($article->getUserID()));
            }
            return $articles;
        } catch (ResourceNotFoundException $exception) {
            return [];
        }
    }
}
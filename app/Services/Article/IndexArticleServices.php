<?php

namespace NewsFeed\Services\Article;

use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Models\Article;
use NewsFeed\Repository\Article\ArticleRepository;
use NewsFeed\Repository\User\UserRepository;

class IndexArticleServices
{
    private ArticleRepository $articleRepository;
    private UserRepository $userRepository;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(): array
    {
        try {
            $articles = $this->articleRepository->createCollection();


            foreach ($articles as $article) {
                /** @var Article $article */
                $article->setUser($this->userRepository->byId($article->getUserID()));
            }
            return $articles;
        } catch (ResourceNotFoundException $exception) {
            return [];
        }
    }
}
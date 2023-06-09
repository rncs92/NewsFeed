<?php

namespace NewsFeed\Services\User\Show;


use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Models\Article;
use NewsFeed\Repository\Article\ArticleRepository;
use NewsFeed\Repository\User\UserRepository;

class ShowUserService
{
    private UserRepository $userRepository;
    private ArticleRepository $articleRepository;

    public function __construct(UserRepository $userRepository, ArticleRepository $articleRepository)
    {
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
    }

    public function handle(ShowUserRequest $request): ShowUserResponse
    {
        $userId = $request->getUserId();
        $user = $this->userRepository->byId($userId);

        $userArticles = $this->articleRepository->createUserArticleCollection($userId);
        foreach ($userArticles as $article) {
            /** @var Article $article */
            $article->setUser($user);
        }

        if ($user == null) {
            throw new ResourceNotFoundException("User Nr. $userId not found!");
        }

        return new ShowUserResponse($user, $userArticles);
    }
}
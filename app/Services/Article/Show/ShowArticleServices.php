<?php declare(strict_types=1);

namespace NewsFeed\Services\Article\Show;

use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Repository\Article\ArticleRepository;
use NewsFeed\Repository\Article\JsonPlaceholderArticleRepository;
use NewsFeed\Repository\Comment\CommentRepository;
use NewsFeed\Repository\Comment\JsonPlaceholderCommentRepository;
use NewsFeed\Repository\User\JsonPlaceholderUserRepository;
use NewsFeed\Repository\User\UserRepository;

class ShowArticleServices
{
    private ArticleRepository $articleRepository;
    private CommentRepository $commentRepository;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->articleRepository = new JsonPlaceholderArticleRepository();
        $this->commentRepository = new JsonPlaceholderCommentRepository();
        $this->userRepository = new JsonPlaceholderUserRepository();
    }

    public function handle(ShowArticleRequest $request): ShowArticleResponse
    {
        $articleId = $request->getArticleId();
        $article = $this->articleRepository->fetchById($articleId);
        $article->setUser($this->userRepository->byId($article->getUserID()));

        if ($article == null) {
            throw new ResourceNotFoundException("Article Nr.$articleId not found!");
        }

        $comments = $this->commentRepository->createCommentsCollection($articleId);

        return new ShowArticleResponse($article, $comments);
    }
}
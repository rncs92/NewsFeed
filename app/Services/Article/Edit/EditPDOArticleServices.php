<?php declare(strict_types=1);

namespace NewsFeed\Services\Article\Edit;

use NewsFeed\Repository\Article\ArticleRepository;

class EditPDOArticleServices
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function handle(EditPDOArticleRequest $request): EditPDOArticleResponse
    {
        $article = $this->articleRepository->fetchById($request->getPostId());


        $article->edit([
            'user_id' => $request->getUserId(),
            'title' => $request->getTitle(),
            'body' => $request->getBody(),
            'id' => $request->getPostId()
        ]);

        $this->articleRepository->update($article);

        return new EditPDOArticleResponse($article);
    }
}

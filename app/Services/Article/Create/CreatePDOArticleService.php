<?php declare(strict_types=1);

namespace NewsFeed\Services\Article\Create;

use Carbon\Carbon;
use NewsFeed\Models\Article;
use NewsFeed\Repository\Article\ArticleRepository;

class CreatePDOArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
        {
            $this->articleRepository = $articleRepository;
        }

    public function handle(CreatePDOArticleRequest $request): CreatePDOArticleResponse
    {
        $article = new Article(
            $request->getUserId(),
            $request->getTitle(),
            $request->getBody(),
            Carbon::now()->toAtomString()
        );

        $this->articleRepository->save($article);

        return new CreatePDOArticleResponse($article);
    }
}

<?php declare(strict_types=1);

namespace NewsFeed\Controllers;

use NewsFeed\Core\TwigView;
use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Services\Article\IndexArticleServices;
use NewsFeed\Services\Article\Show\ShowArticleRequest;
use NewsFeed\Services\Article\Show\ShowArticleServices;

class ArticleController
{
    private IndexArticleServices $indexArticleServices;
    private ShowArticleServices $showArticleServices;

    public function __construct(IndexArticleServices $indexArticleServices, ShowArticleServices $showArticleServices)
    {
        $this->indexArticleServices = $indexArticleServices;
        $this->showArticleServices = $showArticleServices;
    }

    public function index(): TwigView
    {
        $articles = $this->indexArticleServices->handle();

        return new TwigView('index', [
            'posts' => $articles,
        ]);
    }

    public function show(array $vars): TwigView
    {
        try {
            $articleId = $vars['id'] ?? 1;
            $articleRequest = new ShowArticleRequest((int)$articleId);
            $response = $this->showArticleServices->handle($articleRequest);

            return new TwigView('post', [
                'post' => $response->getArticle(),
                'comments' => $response->getComments(),
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notfound', []);
        }
    }
}
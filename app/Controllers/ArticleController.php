<?php declare(strict_types=1);

namespace NewsFeed\Controllers;

use NewsFeed\Core\TwigView;
use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Services\Article\IndexArticleServices;
use NewsFeed\Services\Article\Show\ShowArticleRequest;
use NewsFeed\Services\Article\Show\ShowArticleServices;

class ArticleController
{
    public function index(): TwigView
    {
        $service = new IndexArticleServices();
        $articles = $service->handle();

        return new TwigView('index', [
            'posts' => $articles,
        ]);
    }

    public function show(array $vars): TwigView
    {
        try {
            $articleId = $vars['id'] ?? 1;
            $service = new ShowArticleServices();
            $response = $service->handle(new ShowArticleRequest((int)$articleId));


            return new TwigView('post', [
                'post' => $response->getArticle(),
                'comments' => $response->getComments(),
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notfound', []);
        }
    }
}
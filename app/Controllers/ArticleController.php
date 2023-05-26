<?php declare(strict_types=1);

namespace NewsFeed\Controllers;

use NewsFeed\Core\TwigView;
use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Services\Article\IndexArticleServices;
use NewsFeed\Services\Article\PDOArticleServices;
use NewsFeed\Services\Article\Show\ShowArticleRequest;
use NewsFeed\Services\Article\Show\ShowArticleServices;

class ArticleController
{
    private IndexArticleServices $indexArticleServices;
    private ShowArticleServices $showArticleServices;
    private PDOArticleServices $PDOArticleServices;

    public function __construct(
        IndexArticleServices $indexArticleServices,
        ShowArticleServices  $showArticleServices,
        PDOArticleServices $pdoArticleServices
    )
    {
        $this->indexArticleServices = $indexArticleServices;
        $this->showArticleServices = $showArticleServices;
        $this->PDOArticleServices = $pdoArticleServices;
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

    public function edit(): TwigView
    {
        try {
            $articleId = $vars['id'] ?? 1;
            $articleRequest = new ShowArticleRequest((int)$articleId);
            $response = $this->showArticleServices->handle($articleRequest);

            $this->PDOArticleServices->handleFormUpdate();

            return new TwigView('edit', [
                'post' => $response->getArticle()
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notfound', []);
        }
    }

    public function create(): TwigView
    {
        try {

            $this->PDOArticleServices->handleFormSubmission();

            return new TwigView('createArticle', [

            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notfound', []);
        }
    }

    public function delete(): TwigView
    {
        try {
            $articleId = $vars['id'] ?? 1;
            $this->PDOArticleServices->handleFormDelete($articleId);

            return new TwigView('edit', [

            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notfound', []);
        }
    }
}
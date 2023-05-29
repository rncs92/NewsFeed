<?php declare(strict_types=1);

namespace NewsFeed\Controllers;

use NewsFeed\Core\TwigView;
use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Models\Article;
use NewsFeed\Services\Article\Create\CreatePDOArticleRequest;
use NewsFeed\Services\Article\Create\CreatePDOArticleService;
use NewsFeed\Services\Article\Edit\EditPDOArticleRequest;
use NewsFeed\Services\Article\Edit\EditPDOArticleServices;
use NewsFeed\Services\Article\IndexArticleServices;
use NewsFeed\Services\Article\Show\ShowArticleRequest;
use NewsFeed\Services\Article\Show\ShowArticleServices;

class ArticleController
{
    private IndexArticleServices $indexArticleServices;
    private ShowArticleServices $showArticleServices;
    private CreatePDOArticleService $createPDOArticleService;
    private EditPDOArticleServices $editPDOArticleServices;


    public function __construct(
        IndexArticleServices    $indexArticleServices,
        ShowArticleServices     $showArticleServices,
        CreatePDOArticleService $createPDOArticleService,
        EditPDOArticleServices  $editPDOArticleServices
    )
    {
        $this->indexArticleServices = $indexArticleServices;
        $this->showArticleServices = $showArticleServices;
        $this->createPDOArticleService = $createPDOArticleService;
        $this->editPDOArticleServices = $editPDOArticleServices;
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

    public function create(): TwigView
    {
        return new TwigView('Articles/create', []);
    }

    public function store(): ?Article
    {
        try {
            $createArticle = $this->createPDOArticleService->handle(
                new CreatePDOArticleRequest(
                    (int)$_POST['author'],
                    $_POST['title'],
                    $_POST['body'],
                )
            );

            header("Location: /");
            return $createArticle->getArticle();
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function update(array $vars): TwigView
    {
        try {
            $articleId = $vars['id'];
            $articleRequest = new ShowArticleRequest((int)$articleId);
            $response = $this->showArticleServices->handle($articleRequest);

            return new TwigView('Articles/edit', [
                'post' => $response->getArticle()
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notfound', []);
        }
    }

    public function edit(array $vars): void
    {
        try {
            $id = (int)$vars['id'];

            $updateArticle = $this->editPDOArticleServices->handle(
                new EditPDOArticleRequest(
                    (int)$_POST['author'],
                    $_POST['title'],
                    $_POST['body'],
                    $id
                )
            );

            $article = $updateArticle->getArticle();

            header('Location: /post/' . $article->getPostID());
        } catch (\Exception $exception) {

        }
    }
}
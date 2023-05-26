<?php

namespace NewsFeed\Services\Article;

use NewsFeed\Repository\Article\ArticleRepository;
use Carbon\Carbon;

class PDOArticleServices
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function handleFormSubmission()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $author = $_POST['author'];
            $title = $_POST['title'];
            $body = $_POST['body'];
            $createdAt = Carbon::now();

            try {
                echo 'Success';
                return $this->articleRepository->create($author, $title, $body, $createdAt);
            } catch (\Exception $exception) {
                return 'Failed: ' . $exception->getMessage();
            }
        }
    }

    public function handleFormUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $author = $_POST['author'];
            $title = $_POST['title'];
            $body = $_POST['body'];
            $createdAt = Carbon::now();

            try {
                echo 'Success';
                return $this->articleRepository->update($author, $title, $body, $createdAt);
            } catch (\Exception $exception) {
                return 'Failed: ' . $exception->getMessage();
            }
        }
    }

    public function handleFormDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $author = $_POST['author'];

            try {
                echo 'Success';
                return $this->articleRepository->delete($author);
            } catch (\Exception $exception) {
                return 'Failed: ' . $exception->getMessage();
            }
        }
    }


}
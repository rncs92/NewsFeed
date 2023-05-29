<?php

use NewsFeed\Controllers\ArticleController;
use NewsFeed\Controllers\UserController;

return [
    //Article Indexes
    ['GET', '/', [ArticleController::class, 'index']],
    ['GET', '/post/{id:\d+}', [ArticleController::class, 'show']],
    //Article Create
    ['GET', '/create', [ArticleController::class, 'create']],
    ['POST', '/', [ArticleController::class, 'store']],
    //['GET', '/post', [ArticleController::class, 'show']],
    //Article Edit
    ['GET', '/post/{id:\d+}/edit', [ArticleController::class, 'update']],
    ['POST', '/post/{id:\d+}', [ArticleController::class, 'edit']],
    //Users
    ['GET', '/user', [UserController::class, 'show']],
    ['GET', '/user/{id:\d+}', [UserController::class, 'show']],
];
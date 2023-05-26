<?php

use NewsFeed\Controllers\ArticleController;
use NewsFeed\Controllers\UserController;

return [
    ['GET', '/', [ArticleController::class, 'index']],
    ['GET', '/create', [ArticleController::class, 'create']],
    ['POST', '/create', [ArticleController::class, 'create']],
    ['POST', '/delete/{id:\d+}', [ArticleController::class, 'delete']],
    ['GET', '/post', [ArticleController::class, 'show']],
    ['GET', '/post/{id:\d+}', [ArticleController::class, 'show']],
    ['GET', '/post/{id:\d+}/edit', [ArticleController::class, 'edit']],
    ['GET', '/user', [UserController::class, 'show']],
    ['GET', '/user/{id:\d+}', [UserController::class, 'show']],
];
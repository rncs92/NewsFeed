<?php

use NewsFeed\Controllers\ArticleController;
use NewsFeed\Controllers\UserController;

return [
    ['GET', '/', [ArticleController::class, 'index']],
    ['GET', '/post', [ArticleController::class, 'show']],
    ['GET', '/post/{id:\d+}', [ArticleController::class, 'show']],
    ['GET', '/user', [UserController::class, 'show']],
    ['GET', '/user/{id:\d+}', [UserController::class, 'show']],
];
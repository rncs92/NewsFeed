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
    //Article Edit
    ['GET', '/post/{id:\d+}/edit', [ArticleController::class, 'update']],
    ['POST', '/post/{id:\d+}', [ArticleController::class, 'edit']],
    ['POST', '/post/{id:\d+}/delete', [ArticleController::class, 'delete']],
    //Users
    ['GET', '/user', [UserController::class, 'show']],
    ['GET', '/user/{id:\d+}', [UserController::class, 'show']],
    //Register
    ['GET', '/register', [UserController::class, 'register']],
    ['POST', '/register', [UserController::class, 'store']],
];
<?php

use NewsFeed\Controllers\Controller;

return [
    ['GET', '/', [Controller::class, 'getPosts']],
    ['GET', '/post', [Controller::class, 'viewPost']],
    ['GET', '/post/{id:\d+}', [Controller::class, 'viewPost']],
    ['GET', '/post/user/{id:\d+}', [Controller::class, 'getUsers']],
    ['GET', '/user', [Controller::class, 'getUsers']],
    ['GET', '/user/{id:\d+}', [Controller::class, 'getUsers']],
];
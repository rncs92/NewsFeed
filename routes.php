<?php

use NewsFeed\Controllers\Controller;

return [
    ['GET', '/', [Controller::class, 'getPosts']],
    ['GET', '/post', [Controller::class, 'viewPost']],
    ['GET', '/user', [Controller::class, 'getUsers']],
];
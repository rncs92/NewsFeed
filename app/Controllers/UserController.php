<?php declare(strict_types=1);

namespace NewsFeed\Controllers;

use NewsFeed\Core\TwigView;
use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Services\User\Show\ShowUserRequest;
use NewsFeed\Services\User\Show\ShowUserService;

class UserController
{
    public function show(array $vars): TwigView
    {
        try {
            $userId = isset($vars['id']) ? (int)$vars['id'] : 1;
            $service = new ShowUserService();
            $response = $service->handle(new ShowUserRequest($userId));

            return new TwigView('user', [
                'user' => $response->getUser(),
                'posts' => $response->getArticle(),
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notFound', []);
        }
    }
}
<?php declare(strict_types=1);

namespace NewsFeed\Controllers;

use NewsFeed\Core\TwigView;
use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Services\User\IndexUserServices;
use NewsFeed\Services\User\Show\ShowUserRequest;
use NewsFeed\Services\User\Show\ShowUserService;

class UserController
{
    private IndexUserServices $userServices;
    private ShowUserService $showUserService;

    public function __construct(IndexUserServices $userServices, ShowUserService $showUserService)
    {
        $this->userServices = $userServices;
        $this->showUserService = $showUserService;
    }

    public function index(): TwigView
    {
        $users = $this->userServices->handle();

        return new TwigView('users', [
            'users' => $users,
        ]);
    }

    public function show(array $vars): TwigView
    {
        try {
            $userId = isset($vars['id']) ? (int)$vars['id'] : 1;
            $response = $this->showUserService->handle(new ShowUserRequest($userId));

            return new TwigView('user', [
                'user' => $response->getUser(),
                'posts' => $response->getArticle(),
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notFound', []);
        }
    }
}
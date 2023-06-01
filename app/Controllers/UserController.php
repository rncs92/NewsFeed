<?php declare(strict_types=1);

namespace NewsFeed\Controllers;

use NewsFeed\Core\Redirect;
use NewsFeed\Core\TwigView;
use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Models\User;
use NewsFeed\Services\Article\Create\CreatePDOArticleRequest;
use NewsFeed\Services\User\Index\IndexUserServices;
use NewsFeed\Services\User\Register\RegisterPDOUserRequest;
use NewsFeed\Services\User\Register\RegisterPDOUserResponse;
use NewsFeed\Services\User\Register\RegisterPDOUserService;
use NewsFeed\Services\User\Show\ShowUserRequest;
use NewsFeed\Services\User\Show\ShowUserService;

class UserController
{
    private IndexUserServices $userServices;
    private ShowUserService $showUserService;
    private RegisterPDOUserService $registerPDOUserService;

    public function __construct(
        IndexUserServices      $userServices,
        ShowUserService        $showUserService,
        RegisterPDOUserService $registerPDOUserService
    )
    {
        $this->userServices = $userServices;
        $this->showUserService = $showUserService;
        $this->registerPDOUserService = $registerPDOUserService;
    }

    public function index(): TwigView
    {
        $users = $this->userServices->handle();

        return new TwigView('User/users', [
            'users' => $users,
        ]);
    }

    public function show(array $vars): TwigView
    {
        try {
            $userId = isset($vars['id']) ? (int)$vars['id'] : 1;
            $response = $this->showUserService->handle(new ShowUserRequest($userId));

            return new TwigView('User/user', [
                'user' => $response->getUser(),
                'posts' => $response->getArticle(),
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('Error/notFound', []);
        }
    }

    public function store(): Redirect
    {
        try {
            $user = $this->registerPDOUserService->handle(
                new RegisterPDOUserRequest(
                    $_POST['name'],
                    $_POST['username'],
                    $_POST['email'],
                    $_POST['password'],
                    $_POST['confirm_password']
                )
            );
            $_SESSION['authid'] = $user->getUser()->getUserid();

            return new Redirect("/");
        } catch (\Exception $exception) {
            return new Redirect('/register');
        }
    }

    public function register(): TwigView
    {
        return new TwigView('User/register', []);
    }

    public function logout(): Redirect
    {
        unset($_SESSION['authid']);

        return new Redirect('/');
    }
}
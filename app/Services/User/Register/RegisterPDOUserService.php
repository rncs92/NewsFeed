<?php

namespace NewsFeed\Services\User\Register;

use NewsFeed\Models\User;
use NewsFeed\Repository\User\UserRepository;

class RegisterPDOUserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(RegisterPDOUserRequest $request): RegisterPDOUserResponse
    {
        $user = new User(
            $request->getName(),
            $request->getUsername(),
            $request->getEmail()
        );

        $this->userRepository->save($user);

        return new RegisterPDOUserResponse($user);
    }
}
<?php declare(strict_types=1);

namespace NewsFeed\Services\User\Register;

use InvalidArgumentException;
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
        $userExists = $this->userRepository->byEmail($request->getEmail());
        if($userExists !== null) {
            throw new InvalidArgumentException('User with this email address exists');
        }


        if ($request->getPassword() !== $request->getConfirmPassword()) {
            throw new InvalidArgumentException('Password do not match!');
        }


        $user = new User(
            $request->getName(),
            $request->getUsername(),
            $request->getEmail(),
            password_hash($request->getPassword(), PASSWORD_DEFAULT)
        );

        $this->userRepository->save($user);

        return new RegisterPDOUserResponse($user);
    }
}
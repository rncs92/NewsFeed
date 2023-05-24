<?php

namespace NewsFeed\Services\User;


use NewsFeed\Exceptions\ResourceNotFoundException;
use NewsFeed\Repository\User\UserRepository;

class IndexUserServices
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(): array
    {
        try {
            return $this->userRepository->createCollection();
        } catch (ResourceNotFoundException $exception) {
            return [];
        }
    }
}
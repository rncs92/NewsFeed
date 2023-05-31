<?php

namespace NewsFeed\Services\User\Register;

use NewsFeed\Models\User;

class RegisterPDOUserResponse
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
<?php declare(strict_types=1);

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
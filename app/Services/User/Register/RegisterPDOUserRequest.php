<?php

namespace NewsFeed\Services\User\Register;

class RegisterPDOUserRequest
{
    private string $name;
    private string $username;
    private string $email;

    public function __construct(string $name, string $username, string $email)
    {
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
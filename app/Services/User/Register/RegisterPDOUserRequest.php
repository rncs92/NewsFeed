<?php declare(strict_types=1);

namespace NewsFeed\Services\User\Register;

class RegisterPDOUserRequest
{
    private string $name;
    private string $username;
    private string $email;
    private string $password;
    private string $confirmPassword;

    public function __construct(
        string $name,
        string $username,
        string $email,
        string $password,
        string $confirmPassword)
    {
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }
}
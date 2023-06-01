<?php

namespace NewsFeed\Models;

class User
{
    private string $name;
    private string $username;
    private string $email;
    private string $password;
    private ?int $userid;

    public function __construct(
        string $name,
        string $username,
        string $email,
        string $password,
        int    $userid = null
    )

    {
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->userid = $userid;
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

    public function setUserid(?int $userid): void
    {
        $this->userid = $userid;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }
}
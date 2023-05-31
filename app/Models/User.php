<?php

namespace NewsFeed\Models;

class User
{
    private ?int $userid;
    private string $name;
    private string $username;
    private string $email;

    public function __construct(
        string $name,
        string $username,
        string $email,
        int    $userid = null
    )

    {
        $this->userid = $userid;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
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
}
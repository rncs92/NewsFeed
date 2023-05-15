<?php

namespace NewsFeed\Models;

class User
{
    private int $userid;
    private string $name;
    private string $username;
    private string $email;
    private string $street;
    private string $city;
    private string $company;
    private string $role;
    private string $phone;
    private string $catchPhrase;

    public function __construct(
        int $userid,
        string $name,
        string $username,
        string $email,
        string $street,
        string $city,
        string $company,
        string $role,
        string $phone,
        string $catchPhrase
    )

    {
        $this->userid = $userid;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->street = $street;
        $this->city = $city;
        $this->company = $company;
        $this->role = $role;
        $this->phone = $phone;
        $this->catchPhrase = $catchPhrase;
    }

    public function getUserid(): int
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

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCatchPhrase(): string
    {
        return $this->catchPhrase;
    }
}
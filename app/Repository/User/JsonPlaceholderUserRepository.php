<?php

namespace NewsFeed\Repository\User;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use NewsFeed\Cache;
use NewsFeed\Models\User;
use stdClass;

class JsonPlaceholderUserRepository implements UserRepository
{
    private Client $client;
    private const BASIC_API_URL = 'https://jsonplaceholder.typicode.com';

    public function __construct()
    {
        $this->client = new Client();
    }

    private function all(): array
    {
        try {
            if (!Cache::check('users')) {
                $response = $this->client->request('GET', self::BASIC_API_URL . '/users');
                $rawData = $response->getBody()->getContents();
                Cache::set('users', $rawData);
            } else {
                $rawData = Cache::get('users');
            }
            return json_decode($rawData);
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function byId(int $userId): ?User
    {
        try {
            if (!Cache::check('user_' . $userId)) {
                $response = $this->client->request('GET', self::BASIC_API_URL . "/users/$userId");
                $rawData = $response->getBody()->getContents();
                Cache::set('user_' . $userId, $rawData);
            } else {
                $rawData = Cache::get('user_' . $userId);
            }
            $user = json_decode($rawData);

            return $this->buildModel($user);
        } catch (GuzzleException $exception) {
            return null;
        }
    }

    public function createCollection(): array
    {
        $users = $this->all();

        $usersCollection = [];
        foreach ($users as $user) {
            $usersCollection[] = $this->buildModel($user);
        }
        return $usersCollection;
    }

    private function buildModel(stdClass $user): User
    {
        return new User(
            $user->id,
            $user->name,
            $user->username,
            $user->email,
            $user->address->street,
            $user->address->city,
            $user->company->name,
            $user->company->bs,
            $user->phone,
            $user->company->catchPhrase,
        );
    }
}
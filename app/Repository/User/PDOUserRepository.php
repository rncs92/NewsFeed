<?php

namespace NewsFeed\Repository\User;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use NewsFeed\Core\Database;
use NewsFeed\Models\User;


class PDOUserRepository implements UserRepository
{
    private QueryBuilder $queryBuilder;
    private Connection $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
        $this->queryBuilder = $this->connection->createQueryBuilder();
    }

    public function byId(int $userId): ?User
    {
        $queryBuilder = $this->queryBuilder;
        $user = $queryBuilder->select('*')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $userId)
            ->fetchAssociative();

        return $this->buildModel($user);
    }

    public function createCollection(): array
    {
        $queryBuilder = $this->queryBuilder;
        $users = $queryBuilder->select('*')
            ->from('users')
            ->fetchAllAssociative();

        $userCollection = [];
        foreach ($users as $user) {
            $userCollection [] = $this->buildModel($user);
        }
        return $userCollection;
    }

    public function save(User $user): void
    {
        $queryBuilder = $this->queryBuilder;
        $queryBuilder
            ->insert('user')
            ->values(
                [
                    'name' => '?',
                    'username' => '?',
                    'email' => '?',

                ]
            )
            ->setParameter(0, $user->getName())
            ->setParameter(1, $user->getUsername())
            ->setParameter(2, $user->getEmail());

        $queryBuilder->executeQuery();

        $user->setUserid((int)$this->connection->lastInsertId());
    }

    private function buildModel(array $user): User
    {
        return new User(
            $user['name'],
            $user['username'],
            $user['email'],
            $user['id'],
        );
    }
}
<?php

namespace NewsFeed\Repository\Article;

use Carbon\Carbon;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use NewsFeed\Models\Article;

class PDOArticleRepository implements ArticleRepository
{
    private string $dbname;
    private string $user;
    private string $password;
    private string $host;

    public function __construct()
    {
        $this->dbname = $_ENV['DBNAME'];
        $this->user = $_ENV['USER'];
        $this->password = $_ENV['PASSWORD'];
        $this->host = $_ENV['HOST'];
    }

    public function connect(): ?Connection
    {
        try {
            $connectionParams = [
                'dbname' => $this->dbname,
                'user' => $this->user,
                'password' => $this->password,
                'host' => $this->host,
                'driver' => 'pdo_mysql',
            ];
            return DriverManager::getConnection($connectionParams);
        } catch (Exception $exception) {
            return null;
        }
    }

    public function fetchById(int $articleId): ?Article
    {
        $articles = $this->createCollection();
        foreach ($articles as $article) {
            /** @var Article $article */
            if ($article->getPostID() == $articleId) {
                return $article;
            }
        }
        return $article;
    }

    public function createCollection(): array
    {
        $sql = $this->connect();
        $query = 'SELECT * FROM NewsFeed.Articles';
        $response = $sql->fetchAllAssociative($query);

        $articles = [];
        foreach ($response as $article) {
            $articles[] = $this->buildModel($article);
        }
        return $articles;
    }

    public function createUserArticleCollection(int $userId): array
    {
        $collection = $this->createCollection();
        $articles = [];
        foreach ($collection as $article) {
            /** @var Article $article */
            if ($article->getUserID() == $userId) {
                $articles[] = $article;
            }
        }
        return $articles;
    }

    public function create(int $author, string $title, string $body, Carbon $createdAt): string
    {
        try {
            $data = [
                'user_id' => $author,
                'title' => $title,
                'body' => $body,
                'created_at' => Carbon::now()
            ];

            $connection = $this->connect();

                return $connection->insert('NewsFeed.Articles', $data);
            } catch (\Exception $exception) {
                return 'Failed: ' . $exception->getMessage();
            }
    }

    public function update(int $author, string $title, string $body, Carbon $createdAt): string
    {
        try {
            $data = [
                'user_id' => $author,
                'title' => $title,
                'body' => $body,
                'created_at' => Carbon::now()
            ];

            $criteria = [
                'user_id' => $author
            ];

            $connection = $this->connect();

            return $connection->update('NewsFeed.Articles', $data, $criteria);
        } catch (\Exception $exception) {
            return 'Failed: ' . $exception->getMessage();
        }
    }

    public function delete(int $author): string
    {
        try {
            $criteria = [
                'user_id' => $author
            ];

            $connection = $this->connect();

            return $connection->delete('NewsFeed.Articles', $criteria);
        } catch (\Exception $exception) {
            return 'Failed: ' . $exception->getMessage();
        }
    }

    private function buildModel($article): Article
    {
        return new Article(
            $article['user_id'],
            $article['id'],
            $article['title'],
            $article['body'],
        );
    }
}
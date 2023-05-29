<?php

namespace NewsFeed\Repository\Article;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use NewsFeed\Core\Database;
use NewsFeed\Models\Article;


class PDOArticleRepository implements ArticleRepository
{
    private QueryBuilder $queryBuilder;
    private Connection $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
        $this->queryBuilder = $this->connection->createQueryBuilder();
    }

    public function fetchById(int $articleId): ?Article
    {
        $queryBuilder = $this->queryBuilder;
        $article = $queryBuilder->select('*')
            ->from('Articles')
            ->where('id = ?')
            ->setParameter(0, $articleId)
            ->fetchAssociative();


        return $this->buildModel($article);
    }

    public function createCollection(): array
    {
        $queryBuilder = $this->queryBuilder;
        $articles = $queryBuilder->select('*')
            ->from('Articles')
            ->fetchAllAssociative();

        $articleCollection = [];
        foreach ($articles as $article) {
            $articleCollection [] = $this->buildModel($article);
        }
        return $articleCollection;
    }

    public function createUserArticleCollection(int $userId): array
    {
        $queryBuilder = $this->queryBuilder;
        $collection = $queryBuilder->select('*')
            ->from('Articles')
            ->where('user_id = ?')
            ->setParameter(0, $userId)
            ->fetchAllAssociative();

        $articles = [];
        foreach ($collection as $article) {
            $articles[] = $this->buildModel($article);
        }

        return $articles;
    }

    public function save(Article $article): void
    {
        $queryBuilder = $this->queryBuilder;
        $queryBuilder
            ->insert('Articles')
            ->values(
                [
                    'user_id' => '?',
                    'title' => '?',
                    'body' => '?',
                    'created_at' => '?'
                ]
            )
            ->setParameter(0, $article->getUserID())
            ->setParameter(1, $article->getTitle())
            ->setParameter(2, $article->getBody())
            ->setParameter(3, $article->getCreatedAt());

        $queryBuilder->executeQuery();

        $article->setPostID((int)$this->connection->lastInsertId());
    }

    public function update(Article $article): void
    {
        $queryBuilder = $this->queryBuilder;
        $queryBuilder
            ->update('Articles')
            ->set('user_id', '?')
            ->set('title', '?')
            ->set('body', '?')
            ->where('id = ?')
            ->setParameter(0, $article->getUserID())
            ->setParameter(1, $article->getTitle())
            ->setParameter(2, $article->getBody())
            ->setParameter(3, $article->getPostID());

        $queryBuilder->executeQuery();
    }

    public function delete(int $articleId): void
    {
        $queryBuilder = $this->queryBuilder;
        $queryBuilder
            ->delete('Articles')
            ->where('id = ?')
            ->setParameter(0, $articleId);

        $queryBuilder->executeQuery();
    }

    private function buildModel($article): Article
    {
        return new Article(
            (int)$article['user_id'],
            $article['title'],
            $article['body'],
            $article['created_at'],
            (int)$article['id']
        );
    }
}
<?php

namespace NewsFeed\Repository\Article;

use Doctrine\DBAL\DriverManager;

class PDOArticleRepository
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

        $connectionParams = [
            'dbname' => $this->dbname,
            'user' => $this->user,
            'password' => $this->password,
            'host' => $this->host,
            'driver' => 'pdo_mysql',
        ];
        $conn = DriverManager::getConnection($connectionParams);
    }
}
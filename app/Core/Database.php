<?php declare(strict_types=1);

namespace NewsFeed\Core;

use Doctrine\DBAL\{Connection, DriverManager};

class Database
{
    private static ?Connection $connection = null;

    public static function getConnection(): ?Connection
    {
        if (self::$connection == null) {
            $connectionParams = [
                'dbname' => $_ENV["DBNAME"],
                'user' => $_ENV["USER"],
                'password' => $_ENV["PASSWORD"],
                'host' => $_ENV["HOST"],
                'driver' => 'pdo_mysql',
            ];

            self::$connection = DriverManager::getConnection($connectionParams);
        }
        return self::$connection;
    }
}
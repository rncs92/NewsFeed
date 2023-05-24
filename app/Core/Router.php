<?php

namespace NewsFeed\Core;

use DI\ContainerBuilder;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use NewsFeed\Repository\Article\ArticleRepository;
use NewsFeed\Repository\Article\JsonPlaceholderArticleRepository;
use NewsFeed\Repository\Comment\CommentRepository;
use NewsFeed\Repository\Comment\JsonPlaceholderCommentRepository;
use NewsFeed\Repository\User\JsonPlaceholderUserRepository;
use NewsFeed\Repository\User\UserRepository;
use function FastRoute\simpleDispatcher;


class Router
{
    public static function response(array $routes): ?TwigView
    {

        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            ArticleRepository::class => new JsonPlaceholderArticleRepository(),
            UserRepository::class => new JsonPlaceholderUserRepository(),
            CommentRepository::class => new JsonPlaceholderCommentRepository()
        ]);
        $container = $builder->build();

        $dispatcher = simpleDispatcher(function (RouteCollector $router) use ($routes) {
            foreach ($routes as $route) {
                [$httpMethod, $url, $handler] = $route;
                $router->addRoute($httpMethod, $url, $handler);
            }
        });

// Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                return null;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                return null;
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                [$controllerName, $methodName] = $handler;
                $controller = $container->get($controllerName);

                return $controller->{$methodName}($vars);
        }
        return null;
    }
}
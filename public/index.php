<?php declare(strict_types=1);

use NewsFeed\Core\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


require_once '../vendor/autoload.php';

$loader = new FilesystemLoader('../app/Views');
$twig = new Environment($loader);

$routes = require_once '../routes.php';
$response = Router::response($routes);
echo $twig->render($response->getTemplate() . '.html.twig', $response->getResponse());
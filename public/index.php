<?php declare(strict_types=1);

use NewsFeed\Core\Redirect;
use NewsFeed\Core\Router;
use NewsFeed\Core\TwigView;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


require_once '../vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

$loader = new FilesystemLoader('../app/Views');
$twig = new Environment($loader);

$routes = require_once '../routes.php';
$response = Router::response($routes);

if($response instanceof TwigView) {
    echo $twig->render($response->getTemplate() . '.html.twig', $response->getResponse());
}

if($response instanceof Redirect) {
    header('Location:' . $response->getLocation());
}

<?php declare(strict_types=1);

use NewsFeed\Application;
use NewsFeed\Models\Article;
use NewsFeed\Models\Comment;
use NewsFeed\Models\User;
use NewsFeed\Services\Article\IndexArticleServices;
use NewsFeed\Services\Article\Show\ShowArticleRequest;
use NewsFeed\Services\Article\Show\ShowArticleServices;
use NewsFeed\Services\User\IndexUserServices;
use NewsFeed\Services\User\Show\ShowUserRequest;
use NewsFeed\Services\User\Show\ShowUserService;

require_once '../vendor/autoload.php';

$app = new Application();
$app->run();


$resource = $argv[1] ?? null;
$id = $argv[2] ?? null;

switch ($resource) {
    case 'articles':
        if ($id != null) {
            $service = new ShowArticleServices();
            $response = $service->handle(new ShowArticleRequest((int)$id));
            $article = $response->getArticle();
            $comments = $response->getComments();

            echo 'ARTICLE:' . PHP_EOL;
            echo '---------|' . $article->getTitle() . '|---------' . PHP_EOL;
            echo $article->getBody() . PHP_EOL;
            echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' . PHP_EOL;
            echo 'COMMENTS:' . PHP_EOL;
            foreach ($comments as $comment) {
                /** @var Comment $comment */
                echo '● [Name:] ' . $comment->getName() . ' | [Email:] ' . $comment->getEmail() . PHP_EOL;
                echo $comment->getBody() . PHP_EOL;
                echo PHP_EOL;
            }
        } else {
            $service = new IndexArticleServices();
            $articles = $service->handle();

            /** @var Article $article */
            foreach ($articles as $article) {
                echo '---------|' . $article->getTitle() . '|---------' . PHP_EOL;
                echo $article->getBody() . PHP_EOL;
                echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' . PHP_EOL;
            }
        }
        break;
    case 'users':
        if ($id != null) {
            $service = new ShowUserService();
            $response = $service->handle(new ShowUserRequest((int)$id));
            $user = $response->getUser();
            $articles = $response->getArticle();

            userInfo($user);
            echo '[User Articles]:' . PHP_EOL;
            foreach ($articles as $article) {
                /** @var Article $article */
                echo '➢ ' . $article->getTitle() . PHP_EOL;
            }
            echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' . PHP_EOL;
        } else {
            $service = new IndexUserServices();
            $users = $service->handle();

            /** @var User $user */
            foreach ($users as $user) {
                userInfo($user);
            }
        }
        break;
    default:
        echo 'Invalid resource';
        break;
}

function userInfo(User $user)
{
    echo '             [' . $user->getName() . ']' . PHP_EOL;
    echo '➤ID:[' . $user->getUserid() . ']' . PHP_EOL;
    echo '➤Username: ' . $user->getUsername() . PHP_EOL;
    echo '➤Email: ' . $user->getEmail() . PHP_EOL;
    echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' . PHP_EOL;
    echo '[User Contacts]: ' . PHP_EOL;
    echo '➤Address: ' . $user->getStreet() . ', ' . $user->getCity() . PHP_EOL;
    echo '➤Company: ' . $user->getCompany() . PHP_EOL;
    echo '➤Mobile Number: : ' . $user->getPhone() . PHP_EOL;
    echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' . PHP_EOL;
}

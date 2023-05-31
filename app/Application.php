<?php

namespace NewsFeed;

use NewsFeed\Models\Article;
use NewsFeed\Models\Comment;
use NewsFeed\Models\User;
use NewsFeed\Services\Article\Index\IndexArticleServices;
use NewsFeed\Services\Article\Show\ShowArticleRequest;
use NewsFeed\Services\Article\Show\ShowArticleServices;
use NewsFeed\Services\User\Index\IndexUserServices;
use NewsFeed\Services\User\Show\ShowUserRequest;
use NewsFeed\Services\User\Show\ShowUserService;

class Application
{
    public function run(): void
    {
        while (true) {
            echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' . PHP_EOL;
            echo "              Best Source of Useless News" . PHP_EOL;
            echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' . PHP_EOL;
            echo "Select 1: Find single article by ID(1-100)" . PHP_EOL;
            echo "Select 2: See the list of available articles" . PHP_EOL;
            echo "Select 3: Find single user by ID(1-10)" . PHP_EOL;
            echo "Select 4: See the list of available users" . PHP_EOL;
            echo "Select 0: Exit" . PHP_EOL;
            echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' . PHP_EOL;

            $command = (int)readline();
            if ($command == 0) {
                echo 'Bye, have a nice day!' . PHP_EOL;
                die;
            }
            switch ($command) {
                case 1:
                    $id = readline('Please enter the Article ID(1-100):');
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
                    break;
                case 2:
                    $service = new IndexArticleServices();
                    $articles = $service->handle();

                    /** @var Article $article */
                    foreach ($articles as $article) {
                        echo '---------|' . $article->getTitle() . '|---------' . PHP_EOL;
                        echo $article->getBody() . PHP_EOL;
                        echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' . PHP_EOL;
                    }
                    break;
                case 3:
                    $id = readline('Please enter the User ID(1-10):');
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
                    break;
                case 4:
                    $service = new IndexUserServices();
                    $users = $service->handle();

                    /** @var User $user */
                    foreach ($users as $user) {
                        userInfo($user);
                    }
                    break;
                default:
                    echo "Sorry, I don't understand you.." . PHP_EOL;
            }
        }
    }
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
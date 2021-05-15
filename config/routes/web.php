<?php

use Slim\App;

return function (App $app) {
    $app->get('/', 'App\Controller\HomeController:index');
    $app->map(['GET', 'POST'], '/task-one', 'App\Controller\TaskOneController:index');
    $app->get('/task-two', 'App\Controller\TaskTwoController:index');
    $app->get('/stats', 'App\Controller\StatsController:index')
        ->add(new Tuupola\Middleware\HttpBasicAuthentication([
            "users" => [
                getenv('ADMIN_NAME') => getenv('ADMIN_PASS'),
            ]
        ]));
};

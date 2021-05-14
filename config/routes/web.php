<?php

use Slim\App;

return function (App $app) {
    $app->get('/', 'App\Controller\HomeController:index');

    $app->map(['GET', 'POST'], '/task-one', 'App\Controller\TaskOneController:index');

    $app->get('/task-two', 'App\Controller\TaskTwoController:index');
};

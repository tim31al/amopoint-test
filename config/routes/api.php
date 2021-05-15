<?php


use App\Middleware\ApiAuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api/stats', function (RouteCollectorProxy $group) {
        $group->post('', 'App\Api\Controller\StatsController:addVisitor');
        $group->get('', 'App\Api\Controller\StatsController:showStats');
    })->add($app->getContainer()->get(ApiAuthMiddleware::class));
};


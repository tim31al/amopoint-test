<?php


namespace App\Controller;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StatsController extends AbstractController
{
    const TITLE = 'Статистика';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->addScripts([
            'https://www.gstatic.com/charts/loader.js',
            '/js/stats-chart.js'
        ]);
    }

    public function index(Request $request, Response $response): Response
    {
        return $this->render($response, 'stats/index.php', [
            'title' => self::TITLE,
            'error' => $this->error,
        ]);
    }
}

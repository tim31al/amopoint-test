<?php


namespace App\Controller;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TaskTwoController extends AbstractController
{
    const TITLE = 'Task two';

    /**
     * TaskTwoController constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->addScripts(['task-two.js']);
    }


    public function index(Request $request, Response $response): Response
    {
        return $this->render($response, 'task-two/index.php', [
            'title' => self::TITLE,
        ]);
    }

}

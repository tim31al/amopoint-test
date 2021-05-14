<?php


namespace App\Controller;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TaskTwoController extends AbstractController
{
    public function index(Request $request, Response $response): Response
    {
        $result = 'Task two';

        return $this->render($response, 'task-two/index.php', [
            'result' => $result,
        ]);
    }

}

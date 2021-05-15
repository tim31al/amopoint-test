<?php


namespace App\Api\Controller;


use Fig\Http\Message\StatusCodeInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;

abstract class AbstractController
{
    protected ContainerInterface $container;

    /**
     * AbstractController constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function jsonResponse(Response $response, ?array $data, int $status = StatusCodeInterface::STATUS_OK): Response
    {
        $response->getBody()->write(json_encode($data));
        return $response
            ->withStatus($status)
            ->withHeader('Content-Type', 'application/json');
    }
}

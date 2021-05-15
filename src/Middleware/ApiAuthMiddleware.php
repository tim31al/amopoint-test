<?php


namespace App\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;


class ApiAuthMiddleware
{
    private ContainerInterface $container;

    /**
     * ApiAuthMiddleware constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $authHeader = $request->getHeader('Authorization');

        if (!$authHeader || !$this->checkAuth($authHeader)) {
            return $response->withStatus(StatusCodeInterface::STATUS_FORBIDDEN);
        }

        return $response;
    }

    private function checkAuth($authHeader): bool
    {
        list(, $token) = explode(' ', $authHeader[0]);
        $apiToken = $this->container->get('api-token');

        if ($token !== $apiToken) {
            return false;
        }

        return true;
    }

}

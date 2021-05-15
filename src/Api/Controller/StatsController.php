<?php


namespace App\Api\Controller;


use App\Repository\VisitorRepository;
use App\Service\Visitor\Exception\VisitorInvalidArgumentException;
use App\Service\Visitor\Exception\VisitorNotCreatedException;
use App\Service\Visitor\VisitorService;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StatsController extends AbstractController
{
    public function addVisitor(Request $request, Response $response): Response
    {
        $raw = $request->getParsedBody();
        try {
            $this->container->get(VisitorService::class)->addVisitor($raw);

            return $this->jsonResponse(
                $response, null,
                StatusCodeInterface::STATUS_CREATED
            );
        } catch (VisitorInvalidArgumentException | VisitorNotCreatedException $e) {
            return $this->jsonResponse(
                $response,
                ['error' => $e->getMessage()],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }
    }

    public function showStats(Request $request, Response $response): Response
    {
        $hits = $this->container
                ->get(VisitorRepository::class)
                ->findHits();

        return $this->jsonResponse($response, $hits);
    }
}

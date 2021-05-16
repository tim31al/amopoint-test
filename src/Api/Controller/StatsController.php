<?php


namespace App\Api\Controller;


use App\Repository\VisitorRepository;
use App\Service\Visitor\Exception\VisitorInvalidArgumentException;
use App\Service\Visitor\Exception\VisitorNotCreatedException;
use App\Service\Visitor\VisitorService;
use App\Service\Visitor\VisitorServiceInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StatsController extends AbstractController
{
    private VisitorRepository $repository;
    private VisitorServiceInterface $visitorService;

    /**
     * StatsController constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->repository = $container->get(VisitorRepository::class);
        $this->visitorService = $container->get(VisitorService::class);
    }


    public function addVisitor(Request $request, Response $response): Response
    {
        $raw = $request->getParsedBody();
        try {
            $this->visitorService->addVisitor($raw);

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

    public function show(Request $request, Response $response): Response
    {
        try {
            $params = $request->getQueryParams();
            $date = isset($params['date']) ? htmlspecialchars($params['date']) : 'now';

            $hits = $this->repository->getStatsByHour($date);
            $cities = $this->repository->getStatsByCity($date);

            return $this->jsonResponse($response, [
                'hours' => $hits,
                'cities' => $cities,
                'date' => $date,
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse($response, [
                'hours' => [],
                'cities' => [],
                'error' => $e->getMessage()
            ]);
        }
//        $params = $request->getQueryParams();
//        $date = $params['date'] ? htmlspecialchars($params['date']) : null;
//
//        $hits = $this->repository->getStatsByHour($date);
//        $cities = $this->repository->getStatsByCity($date);

//        return $this->jsonResponse($response, [
//            'hours' => $hits,
//            'cities' => $cities,
//            ]);
    }

}

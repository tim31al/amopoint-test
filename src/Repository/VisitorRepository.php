<?php


namespace App\Repository;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class VisitorRepository
{
    private EntityManagerInterface $entityManager;

    /**
     * VisitorRepository constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function getStatsByHour()
    {
        $sql = 'SELECT DISTINCT extract(HOUR FROM datevisit)::integer as hour, count(distinct ip) as count ' .
               'FROM visitors WHERE datevisit::date = current_date GROUP BY hour ORDER BY hour';

        $conn = $this->entityManager->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->executeStatement();
        return $stmt->fetchAll();
    }

    public function getStatsByCity()
    {
        $sql = 'SELECT DISTINCT city, COUNT(city) as count FROM visitors GROUP BY city';

        $conn = $this->entityManager->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->executeStatement();
        return $stmt->fetchAll();
    }

}


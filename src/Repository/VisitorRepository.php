<?php


namespace App\Repository;


use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class VisitorRepository
{
    private EntityManagerInterface $entityManager;
    private Connection $connection;

    /**
     * VisitorRepository constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->entityManager = $container->get(EntityManager::class);
        $this->connection = $this->entityManager->getConnection();
    }

    public function getStatsByHour(string $date = null)
    {
        if (null !== $date) {
            $sql = 'SELECT DISTINCT extract(HOUR FROM datevisit)::integer as hour, count(distinct ip) as count ' .
                'FROM visitors WHERE datevisit::date = ? GROUP BY hour ORDER BY hour';

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $this->getDateTime($date), 'datetime');
        } else {
            $sql = 'SELECT DISTINCT extract(DAY FROM datevisit)::integer as hour, count(distinct ip) as count ' .
                'FROM visitors GROUP BY hour ORDER BY hour';

            $stmt = $this->connection->prepare($sql);
        }

        $stmt->executeStatement();
        return $stmt->fetchAll();
    }

    public function getStatsByCity(string $date = null)
    {
        if (null !== $date) {
            $sql = 'SELECT DISTINCT city, COUNT(city) as count FROM visitors WHERE datevisit::date = ? GROUP BY city';

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(1, $this->getDateTime($date), 'datetime');
        } else {
            $sql = 'SELECT DISTINCT city, COUNT(city) as count FROM visitors GROUP BY city';

            $stmt = $this->connection->prepare($sql);
        }

        $stmt->executeStatement();
        return $stmt->fetchAll();
    }

    private function getDateTime(string $date): DateTime
    {
        try {
            $dateObj = new DateTime($date);
        } catch (\Exception $e) {
            $dateObj = new DateTime('now');
        }

        return $dateObj;
    }

}


<?php


namespace App\Service\Visitor;


use App\Entity\builder\VisitorBuilder;
use App\Entity\builder\VisitorBuilderInterface;
use App\Service\Visitor\Exception\VisitorInvalidArgumentException;
use App\Service\Visitor\Exception\VisitorNotCreatedException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class VisitorService implements VisitorServiceInterface
{
    private EntityManagerInterface $entityManager;
    private VisitorBuilderInterface $visitorBuilder;

    /**
     * VisitorService constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->entityManager = $container->get(EntityManager::class);
        $this->visitorBuilder = $container->get(VisitorBuilder::class);
    }


    /**
     * @throws \App\Service\Visitor\Exception\VisitorNotCreatedException
     */
    public function addVisitor(array $raw): void
    {
        if (
            !array_key_exists('ip', $raw) ||
            !array_key_exists('city', $raw) ||
            !array_key_exists('device', $raw)
        ) {
            throw new VisitorInvalidArgumentException();
        }
        try {
            $visitor = $this->visitorBuilder->build($raw);
            $this->entityManager->persist($visitor);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new VisitorNotCreatedException();
        }

    }
}

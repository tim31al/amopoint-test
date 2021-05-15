<?php

use App\Entity\builder\VisitorBuilder;
use App\Middleware\ApiAuthMiddleware;
use App\Repository\VisitorRepository;
use App\Service\FileReader\FileReaderInterface;
use App\Service\FileReader\TextFileReader;
use App\Service\FileUploader\FileUploaderInterface;
use App\Service\FileUploader\TextFileUploader;
use App\Service\Storage\FileStorage;
use App\Service\Storage\FileStorageInterface;
use App\Service\Visitor\VisitorService;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;


return [
    EntityManager::class => function (ContainerInterface $container): EntityManager {

        $config = Setup::createAnnotationMetadataConfiguration(
            $container->get('doctrine')['metadata_dirs'],
            $container->get('doctrine')['isDevMode']
        );

        $driverImpl = new AnnotationDriver(new AnnotationReader, $container->get('doctrine')['metadata_dirs']);
        $config->setMetadataDriverImpl($driverImpl);

        return EntityManager::create($container->get('doctrine')['connection'], $config);
    },
    FileStorageInterface::class => fn (ContainerInterface $container) => new FileStorage($container),
    FileUploaderInterface::class => fn (ContainerInterface $container) => new TextFileUploader($container),
    FileReaderInterface::class => fn () => new TextFileReader(),
    VisitorBuilder::class => fn() => new VisitorBuilder(),
    VisitorService::class => fn(ContainerInterface $container) => new VisitorService($container),
    ApiAuthMiddleware::class => fn(ContainerInterface $container) => new ApiAuthMiddleware($container),
    VisitorRepository::class => fn(ContainerInterface $container) => new VisitorRepository($container),
];

<?php


namespace App\Command;



use App\Utils\Config;
use Doctrine\ORM\EntityManager;
use Faker\Factory;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

class App extends Application
{
    private ContainerInterface $container;

    /**
     * App constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->container = (new Config)->buildContainer();

        $faker = Factory::create('ru_RU');
        $em = $this->container->get(EntityManager::class);

        $this->addCommands([
            new FakerVisitorCommand($em, $faker),
        ]);
    }


}

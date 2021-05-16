<?php


namespace App\Command;


use App\Entity\Visitor;
use Doctrine\ORM\EntityManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakerVisitorCommand extends Command
{
    protected static $defaultName = 'fake:visitors';

    protected EntityManager $em;
    protected Generator $faker;

    /**
     * DoctrineCommand constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct();
        $this->em = $entityManager;
        $this->faker = Factory::create('ru_RU');
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Создание фейковых посетителей.')
            ->setHelp('Команда создает в базе случайных посетителей. Производится запись в таблицу visitors');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $arrayLength = 5;

            $ips = [];
            $cities = [];
            $devices = [];

            foreach (range(1, $arrayLength) as $_) {
                array_push($ips, $this->faker->ipv4);
                array_push($cities, $this->faker->city);
                array_push($devices, $this->faker->userAgent);
            }


            for ($i = 10; $i >= 0; $i--) {
                for ($j = 0; $j < 100; $j++) {

                    $date = new \DateTime();
                    $date->modify(sprintf('-%d days', $i));
                    $date->setTime(rand(0, 24), rand(0, 59), rand(0, 59));

                    $index = rand(0, $arrayLength - 1);

                    $visitor = new Visitor();
                    $visitor
                        ->setIp($ips[$index])
                        ->setCity($cities[$index])
                        ->setDevice($devices[$index])
                        ->setDateVisit($date);

                    $this->em->persist($visitor);
                }
            }

            $this->em->flush();

            echo 'Done!', PHP_EOL;

        } catch (\Exception $e) {

            echo $e->getMessage(), PHP_EOL;
            echo $e->getFile() . ':' . $e->getLine();

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

}

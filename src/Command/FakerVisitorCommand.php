<?php


namespace App\Command;


use App\Entity\Visitor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakerVisitorCommand extends AbstractFakeCommand
{
    protected static $defaultName = 'fake:visitors';

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a fake visitors.')
            ->setHelp('This command allows you to create visitors...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {

            foreach (range(1, 100) as $_) {

                $visitor = new Visitor();
                $visitor->setIp($this->faker->ipv4);
                $visitor->setCity($this->faker->city);
                $visitor->setDevice($this->faker->userAgent);
//                    $visitor->setDateVisit($this->faker->dateTimeBetween('-10 days'));

                $this->em->persist($visitor);
            }

            $this->em->flush();

        } catch (\Exception $e) {

            echo $e->getMessage(), PHP_EOL;
            echo $e->getFile() . ':' . $e->getLine();

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

}

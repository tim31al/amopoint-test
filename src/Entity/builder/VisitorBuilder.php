<?php


namespace App\Entity\builder;


use App\Entity\Visitor;

class VisitorBuilder implements VisitorBuilderInterface
{

    public function build(array $raw): Visitor
    {
        $visitor = new Visitor();

        $visitor
            ->setCity($raw['city'])
            ->setIp($raw['ip'])
            ->setDevice($raw['device']);


        return $visitor;
    }
}

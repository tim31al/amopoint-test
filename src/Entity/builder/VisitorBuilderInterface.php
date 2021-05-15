<?php


namespace App\Entity\builder;


use App\Entity\Visitor;

interface VisitorBuilderInterface
{
    public function build(array $raw): Visitor;
}

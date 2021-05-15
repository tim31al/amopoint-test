<?php


namespace App\Service\Visitor;


interface VisitorServiceInterface
{
    /**
     * @param array $raw
     * @throws \App\Service\Visitor\Exception\VisitorNotCreatedException
     * @throws \App\Service\Visitor\Exception\VisitorInvalidArgumentException
     */
    public function addVisitor(array $raw): void;
}

<?php


namespace App\Service\FileReader;


interface FileReaderInterface
{
    public function read(string $filename): array;
}

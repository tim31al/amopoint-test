<?php


namespace App\Service\Storage;


use Psr\Http\Message\UploadedFileInterface;

interface FileStorageInterface
{
    public function moveUploadedFile(string $filename, UploadedFileInterface $uploadedFile): void;
    public function get(string $filename): string;
}

<?php


namespace App\Service\FileUploader;


use Psr\Http\Message\ServerRequestInterface;

interface FileUploaderInterface
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param string $fieldName
     * @return string
     *
     * @throws \App\Service\FileUploader\Exception\FileNotUploadedException
     * @throws \App\Service\FileUploader\Exception\FileTypeException
     */
    public function upload(ServerRequestInterface $request, string $fieldName): string;
}

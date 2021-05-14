<?php


namespace App\Service\FileUploader;


use App\Service\FileUploader\Exception\FileNotUploadedException;
use App\Service\FileUploader\Exception\FileTypeException;
use App\Service\Storage\Exception\MoveFileException;
use App\Service\Storage\FileStorageInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;


class TextFileUploaderService implements FileUploaderInterface
{
    private FileStorageInterface $fileStorage;

    /**
     * TextFileUploaderService constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->fileStorage = $container->get(FileStorageInterface::class);
    }


    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param string $fieldName
     * @return string
     * @throws \App\Service\FileUploader\Exception\FileNotUploadedException
     * @throws \App\Service\FileUploader\Exception\FileTypeException
     */
    public function upload(ServerRequestInterface $request, string $fieldName): string
    {
        $uploadedFiles = $request->getUploadedFiles();
        /* @var  \Psr\Http\Message\UploadedFileInterface $uploadedFile */
        $uploadedFile = $uploadedFiles[$fieldName];

        $this->checkFileType($uploadedFile);

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

            try {
                $basename = bin2hex(random_bytes(10));
                $filename = sprintf('%s.%0.8s', $basename, $extension);

                $this->fileStorage->moveUploadedFile($filename, $uploadedFile);
            } catch (MoveFileException $e) {
                throw new FileNotUploadedException('Не удалось загрузить файл.');
            }

            return $this->fileStorage->get($filename);
        }
    }


    /**
     * @param \Psr\Http\Message\UploadedFileInterface $uploadedFile
     * @throws \App\Service\FileUploader\Exception\FileTypeException
     */
    private function checkFileType(UploadedFileInterface $uploadedFile)
    {
        if ($uploadedFile->getClientMediaType() !== 'text/plain') {
            throw new FileTypeException('Файл не является текстовым.');
        }
    }

}

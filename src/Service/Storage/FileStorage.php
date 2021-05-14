<?php


namespace App\Service\Storage;


use App\Service\Storage\Exception\MoveFileException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\UploadedFileInterface;

class FileStorage implements FileStorageInterface
{
    private string $path;

    /**
     * FileStorage constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->path = $container->get('files_dir');
    }


    /**
     * Сохраняет загруженный файл
     *
     * @param string $filename
     * @param \Psr\Http\Message\UploadedFileInterface $uploadedFile
     * @throws \App\Service\Storage\Exception\MoveFileException
     */
    public function moveUploadedFile(string $filename, UploadedFileInterface $uploadedFile): void
    {
        try {
            $uploadedFile->moveTo($this->path . DIRECTORY_SEPARATOR . $filename);
        } catch (\Exception $e) {
            throw new MoveFileException();
        }
    }

    /**
     * Возвращает полное имя файла
     *
     * @param string $filename
     * @return string
     */
    public function get(string $filename): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $filename;
    }
}

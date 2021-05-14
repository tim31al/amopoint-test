<?php


namespace App\Controller;


use App\Service\FileReader\FileReaderInterface;
use App\Service\FileReader\TextFileReader;
use App\Service\FileUploader\Exception\FileNotUploadedException;
use App\Service\FileUploader\Exception\FileTypeException;
use App\Service\FileUploader\FileUploaderInterface;
use App\Service\Storage\Exception\MoveFileException;
use App\Service\Storage\FileStorage;
use App\Service\Storage\FileStorageInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TaskOneController extends AbstractController
{
    const TITLE = 'Task one';

    private FileUploaderInterface $fileUploader;
    private FileReaderInterface $fileReader;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->addScripts(['form-check.js']);

        $this->fileUploader = $container->get(FileUploaderInterface::class);
        $this->fileReader = $container->get(FileReaderInterface::class);
    }

    public function index(Request $request, Response $response): Response
    {
        $error = null;
        $result = null;

        if ($request->getMethod() === 'POST') {
            try {
                $filename = $this->fileUploader->upload($request, 'file');
                $result = $this->fileReader->read($filename);
            } catch (FileNotUploadedException | FileTypeException $e) {
                $error = $e->getMessage();
            }
        }


        return $this->render($response, 'task-one/index.php', [
            'title' => self::TITLE,
            'result' => $result,
            'error' => $error,
        ]);
    }

}

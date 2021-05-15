<?php


namespace App\Controller;


use App\Service\FileReader\FileReaderInterface;
use App\Service\FileUploader\Exception\FileNotUploadedException;
use App\Service\FileUploader\Exception\FileTypeException;
use App\Service\FileUploader\FileUploaderInterface;
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
        $this->addScripts(['/js/form-check.js']);

        $this->fileUploader = $container->get(FileUploaderInterface::class);
        $this->fileReader = $container->get(FileReaderInterface::class);
    }

    public function index(Request $request, Response $response): Response
    {
        if ($request->getMethod() === 'POST') {
            try {
                $filename = $this->fileUploader->upload($request, 'file');
                $result = $this->fileReader->read($filename);
            } catch (FileNotUploadedException | FileTypeException $e) {
                $this->error = $e->getMessage();
            }
        }


        return $this->render($response, 'task-one/index.php', [
            'title' => self::TITLE,
            'result' => $result ?? null,
            'error' => $this->error,
        ]);
    }

}

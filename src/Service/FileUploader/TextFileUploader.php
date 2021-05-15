<?php


namespace App\Service\FileUploader;


use Psr\Container\ContainerInterface;


class TextFileUploader extends AbstractFileUploader
{

    /**
     * TextFileUploader constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->fileType = 'text/plain';
        $this->checkFileTypeErrorMessage = 'Файл не является текстовым.';
    }

}

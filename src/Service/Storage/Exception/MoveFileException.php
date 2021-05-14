<?php


namespace App\Service\Storage\Exception;


class MoveFileException extends \Exception
{
    protected $message = 'File not moved';
}

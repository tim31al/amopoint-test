<?php

namespace App\Controller;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

abstract class AbstractController
{

    /**
     * @var PhpRenderer $view
     */
    protected PhpRenderer $view;


    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->view = new PhpRenderer(
            dirname(__DIR__, 1) . '/../templates',
            [
                'title' => $container->get('app_name'),
                'app_name' => $container->get('app_name'),
                'styles' => ['bootstrap.min.css'],
                'scripts' => [],
            ],
            'layout.php'
        );

    }

    protected function addScripts(array $scripts)
    {
        $this->view->addAttribute('scripts', $scripts);
    }

    protected function addStyles(array $styles)
    {
        $this->view->addAttribute(
            'styles',
            array_merge($this->view->getAttribute('styles'), $styles)
        );
    }

    protected function render(Response $response, string $template, array $params = []): Response
    {
        return $this->view->render($response, $template, $params);
    }
}

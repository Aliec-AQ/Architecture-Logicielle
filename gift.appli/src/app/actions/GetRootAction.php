<?php
namespace gift\appli\app\actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Views\Twig;

class GetRootAction extends AbstractAction 
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        $view = Twig::fromRequest($request);
        return $view->render($response, 'Root.twig');
    }
}
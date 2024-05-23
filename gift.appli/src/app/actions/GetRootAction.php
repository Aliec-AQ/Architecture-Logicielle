<?php
namespace gift\appli\app\actions;

class GetRootAction extends \gift\appli\app\actions\AbstractAction 
{
    public function __invoke($request, $response, $args)
    {

        $view = \Slim\Views\Twig::fromRequest($request);
        return $view->render($response, 'Root.twig');
    }
}
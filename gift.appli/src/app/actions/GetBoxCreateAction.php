<?php
namespace gift\appli\app\actions;

class GetBoxCreateAction extends \gift\appli\app\actions\AbstractAction 
{
    public function __invoke($request, $response, $args)
    {

        $view = \Slim\Views\Twig::fromRequest($request);
        return $view->render($response, 'BoxCreate.twig');
    }
}
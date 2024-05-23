<?php
namespace gift\appli\app\actions;

class PostBoxCreateAction extends \gift\appli\app\actions\AbstractAction 
{
    public function __invoke($request, $response, $args)
    {
        $postData = $request->getParsedBody();


        $view = \Slim\Views\Twig::fromRequest($request);
        return $view->render($response, 'BoxCreatePost.twig', ['postData' => $postData]);
    }
}
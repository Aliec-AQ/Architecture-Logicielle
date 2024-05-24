<?php

namespace gift\appli\app\actions;

use gift\appli\models\Box;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class GetBoxsPredefinisAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $boxsPredefinies = Box::where('statut',"=", 5)->get();


        if($boxsPredefinies->isEmpty()){
            $boxsPredefinies = null;
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxsPredefinies.twig', ['boxsPredefinies' => $boxsPredefinies]);
    }
}
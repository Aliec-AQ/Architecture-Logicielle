<?php
namespace gift\appli\app\actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Views\Twig;
use gift\appli\models\Categorie;


class GetCategorieAction extends AbstractAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $categories = Categorie::all();

        $view = Twig::fromRequest($request);
        return $view->render($response, 'Categories.twig', ['categories' => $categories]);
    }
}
<?php
namespace gift\appli\app\actions;

use function Sodium\add;

class GetCategorieAction extends \gift\appli\app\actions\AbstractAction
{
    public function __invoke($request, $response, $args)
    {
        $categories = \gift\appli\models\Categorie::all();

        $view = \Slim\Views\Twig::fromRequest($request);
        return $view->render($response, 'Categories.twig', ['categories' => $categories]);
    }
}
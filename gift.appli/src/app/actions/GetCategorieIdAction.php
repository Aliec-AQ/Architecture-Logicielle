<?php
namespace gift\appli\app\actions;

class GetCategorieIdAction extends \gift\appli\app\actions\AbstractAction
{
    public function __invoke($request, $response, $args)
    {
        $id = $args['id'];

        if ($id === null) {
            throw new \Slim\Exception\HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        $category = \gift\appli\models\Categorie::find($id);

        if ($category === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, "Catégorie non trouvée");
        }

        $view = \Slim\Views\Twig::fromRequest($request);
        return $view->render($response, 'CategorieById.twig', $category->toArray());
    }
}
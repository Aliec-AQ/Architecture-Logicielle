<?php
namespace gift\appli\app\actions;

class GetPrestationsCategorieAction extends \gift\appli\app\actions\AbstractAction 
{
    public function __invoke($request, $response, $args)
    {
        $id = $args['id'];

        if ($id === null) {
            throw new \Slim\Exception\HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        $prestations = \gift\appli\models\Categorie::find($id)->prestations;

        if ($prestations === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, "Aucune prestation trouvée");
        }

        $view = \Slim\Views\Twig::fromRequest($request);
        return $view->render($response, 'PrestationCategorie.twig', ['prestations' => $prestations, 'id' => $id]);
    }
}
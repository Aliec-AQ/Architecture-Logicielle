<?php
namespace gift\appli\app\actions;

class GetPrestationsCategorieController
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

        $html = "<h1>Catégorie {$id} :</h1>";
        foreach ($prestations as $prestation) {
            $html .= <<<HTML
            <p><a href="../../prestation?id={$prestation->id}">{$prestation->libelle}</a></p>
            HTML;
        }

        $response->getBody()->write($html);
        return $response;
    }
}
<?php
namespace gift\appli\app\actions;

class GetCategorieIdController
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

        $html = <<<HTML
        <h1>Category</h1>
        <p>ID: {$category['id']}</p>
        <p>Libelle: {$category['libelle']}</p>
        <p>Description: {$category['description']}</p>
        <a href="{$id}/prestations">Voir les prestations de la catégorie</a>
        HTML;

        $response->getBody()->write($html);
        return $response;
    }
}
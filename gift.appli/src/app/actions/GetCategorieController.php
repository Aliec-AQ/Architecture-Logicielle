<?php
namespace gift\appli\app\actions;

class GetCategorieController
{
    public function __invoke($request, $response, $args)
    {
        $categories = \gift\appli\models\Categorie::all();

        if($categories === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, "Aucune catégorie trouvée");
        }
    
        $html = <<<HTML
        <h1>Categories</h1>
        HTML;
        foreach ($categories as $category) {
            $url = 'categorie/' . $category['id'];
            $html .= <<<HTML
            <p><a href="$url">ID: {$category['id']}, Libelle: {$category['libelle']}</a></p>
            HTML;
        }

        $response->getBody()->write($html);
        return $response;
    }
}
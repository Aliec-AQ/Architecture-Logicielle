<?php
namespace gift\api\app\actions\catalogue;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\api\app\actions\AbstractAction;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

use gift\api\core\services\catalogue\CatalogueService;
use gift\api\core\services\catalogue\CatalogueServiceInterface;
use gift\api\core\services\catalogue\CatalogueServiceNotFoundException;


class GetCategorieAction extends \gift\api\app\actions\AbstractAction
{
    private CatalogueServiceInterface $catalogueService;
    
    public function __construct(){
        $this->catalogueService = new CatalogueService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try{
            $categories = $this->catalogueService->getCategories();
        } catch (CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Catégories non trouvées");
        }



        $categoriesArray = [];
        foreach ($categories as $categorie) {
            $categoriesArray[] = [
                'categorie' => [
                    'id' => $categorie['id'],
                    'libelle' => $categorie['libelle'],
                    'description' => $categorie['description']
                ],
                'links' => [
                    'self' => [
                        'href' => "/api/categories/" . $categorie['id'] . "/"
                    ]
                ]
            ];
        }

        $data = [
            'type' => 'collection',
            'count' => count($categories),
            'categories' => $categoriesArray,
        ];

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
<?php

namespace gift\api\app\actions\catalogue;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\api\app\actions\AbstractAction;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

use gift\api\core\services\catalogue\CatalogueService;
use gift\api\core\services\catalogue\CatalogueServiceInterface;
use gift\api\core\services\catalogue\CatalogueServiceNotFoundException;

class GetListePrestationsAction extends \gift\api\app\actions\AbstractAction
{

    private CatalogueServiceInterface $catalogueService;
    
    public function __construct(){
        $this->catalogueService = new CatalogueService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $sort = $request->getQueryParams()['sort'] ?? "";

        try{
            $prestations = $this->catalogueService->getPrestations();
        } catch (CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Prestations non trouvées");
        }

        $prestationsArray = [];
        foreach ($prestations as $prestation) {
            $prestationsArray[] = [
                'prestation' => [
                    'id' => $prestation['id'],
                    'libelle' => $prestation['libelle'],
                    'description' => $prestation['description'],
                    'unite' => $prestation['unite'],
                    'tarif' => $prestation['tarif'],
                    'img' => "/img/" . $prestation['img'],
                    'cat_id' => $prestation['cat_id']
                ],
                'links' => [
                    'self' => [
                        'href' => "/api/prestations/" . $prestation['id'] . "/"
                    ]
                ]
            ];
        }

        $data = [
            'type' => 'collection',
            'count' => count($prestations),
            'prestations' => $prestationsArray
        ];

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}

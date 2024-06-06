<?php
namespace gift\api\app\actions\catalogue;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

use gift\api\core\services\catalogue\CatalogueService;
use gift\api\core\services\catalogue\CatalogueServiceInterface;
use gift\api\core\services\catalogue\CatalogueServiceNotFoundException;

use gift\api\app\utils\CsrfService;

class GetPrestationAction extends \gift\api\app\actions\AbstractAction
{
    
    private CatalogueServiceInterface $catalogueService;
    
    public function __construct(){
        $this->catalogueService = new CatalogueService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args['id'];

        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        try{
            $prestation = $this->catalogueService->getPrestationById($id);
        } catch (CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Prestation non trouvée");
        }
        

        $data = [
            'type' => 'ressource',
            'id' => $prestation['id'],
            'libelle' => $prestation['libelle'],
            'description' => $prestation['description'],
            'unite' => $prestation['unite'],
            'tarif' => $prestation['tarif'],
            'img' => "/img/" . $prestation['img'],
            'cat_id' => $prestation['cat_id']
        ];

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
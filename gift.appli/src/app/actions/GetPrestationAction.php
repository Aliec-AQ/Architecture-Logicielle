<?php
namespace gift\appli\app\actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

use gift\appli\core\services\catalogue\CatalogueService;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;

class GetPrestationAction extends AbstractAction 
{
    
    private string $template;
    private CatalogueServiceInterface $catalogueService;
    
    public function __construct(){
        $this->template = 'Prestation.twig';
        $this->catalogueService = new CatalogueService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $request->getQueryParams()['id'] ?? null;


        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        try{
            $prestation = $this->catalogueService->getPrestationById($id);
        } catch (\CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Prestation non trouvée");
        }
        

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['prestation' => $prestation]);
    }
}
<?php

namespace gift\appli\app\actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

use gift\appli\core\services\catalogue\CatalogueService;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;

class GetListePrestationsAction extends AbstractAction 
{

    private string $template;
    private CatalogueServiceInterface $catalogueService;
    
    public function __construct(){
        $this->template = 'ListePrestation.twig';
        $this->catalogueService = new CatalogueService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $sort = $request->getQueryParams()['sort'] ?? "";

        try{
            $prestations = $this->catalogueService->getPrestationsSorted($sort);
        } catch (\CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Prestations non trouvées");
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['prestations' => $prestations]);
    }
}

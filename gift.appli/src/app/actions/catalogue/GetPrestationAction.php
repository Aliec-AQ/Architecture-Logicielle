<?php
namespace gift\appli\app\actions\catalogue;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

use gift\appli\core\services\catalogue\CatalogueService;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\services\autorisation\AutorisationService;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\app\provider\authentification\AuthentificationProvider;


class GetPrestationAction extends \gift\appli\app\actions\AbstractAction 
{
    
    private string $template;
    private CatalogueServiceInterface $catalogueService;
    private AutorisationServiceInterface $autorisationService;
    private AuthentificationProviderInterface $provider;
    
    public function __construct(){
        $this->template = 'Prestation.twig';
        $this->catalogueService = new CatalogueService();
        $this->autorisationService = new AutorisationService();
        $this->provider = new AuthentificationProvider();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $request->getQueryParams()['id'] ?? null;

        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        $granted = $this->autorisationService->isGranted($this->provider->getSignedInUser()['id'], $this->autorisationService::MODIF_CATALOGUE);

        try{
            $prestation = $this->catalogueService->getPrestationById($id);
        } catch (CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Prestation non trouvée");
        }
        
        $csrf_token = CsrfService::generate();

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['prestation' => $prestation, 'csrf_token' => $csrf_token, 'admin' => $granted]);
    }
}
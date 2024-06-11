<?php
namespace gift\appli\app\actions\catalogue;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Views\Twig;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\services\autorisation\AutorisationService;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\app\provider\authentification\AuthentificationProvider;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueService;

class GetPrestationUpdateAction extends \gift\appli\app\actions\AbstractAction
{

    private string $template;
    private AutorisationServiceInterface $autorisationService;
    private AuthentificationProviderInterface $provider;
    private CatalogueServiceInterface $catalogueService;
    
    public function __construct(){
        $this->template = 'PrestationUpdate.twig';
        $this->autorisationService = new AutorisationService();
        $this->provider = new AuthentificationProvider();
        $this->catalogueService = new CatalogueService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $granted = $this->autorisationService->isGranted($this->provider->getSignedInUser()['id'], $this->autorisationService::MODIF_CATALOGUE);
        if(!$granted){
            return $response->withStatus(302)->withHeader('Location', "/");
        }

        $id = $args['id'];

        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        try{
            $prestation = $this->catalogueService->getPrestationById($id);
        } catch (CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Prestation non trouvée");
        }

        try{
            $categories = $this->catalogueService->getCategories();
        } catch (CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Catégorie non trouvée");
        }

        $token = CsrfService::generate();

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['csrf_token' => $token, 'prestation' => $prestation, 'categories' => $categories]);
    }
}
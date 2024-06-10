<?php
namespace gift\appli\app\actions\catalogue;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Views\Twig;

use gift\appli\core\services\catalogue\CatalogueService;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;

use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\services\autorisation\AutorisationService;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\app\provider\authentification\AuthentificationProvider;

class GetCategorieAction extends \gift\appli\app\actions\AbstractAction
{

    private string $template;
    private CatalogueServiceInterface $catalogueService;
    private AutorisationServiceInterface $autorisationService;
    private AuthentificationProviderInterface $provider;
    
    public function __construct(){
        $this->template = 'Categories.twig';
        $this->catalogueService = new CatalogueService();
        $this->autorisationService = new AutorisationService();
        $this->provider = new AuthentificationProvider();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $granted = $this->autorisationService->isGranted($this->provider->getSignedInUser()['id'], $this->autorisationService::MODIF_CATALOGUE);

        try{
            $categories = $this->catalogueService->getCategories();
        } catch (CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Catégories non trouvées");
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['categories' => $categories, 'admin' => $granted]);
    }
}
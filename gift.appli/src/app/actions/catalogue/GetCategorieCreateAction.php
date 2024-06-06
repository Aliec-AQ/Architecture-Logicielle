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

class GetCategorieCreateAction extends \gift\appli\app\actions\AbstractAction
{

    private string $template;
    private AutorisationServiceInterface $autorisationService;
    private AuthentificationProviderInterface $provider;
    
    public function __construct(){
        $this->template = 'CategorieCreate.twig';
        $this->autorisationService = new AutorisationService();
        $this->provider = new AuthentificationProvider();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $granted = $this->autorisationService->isGranted($this->provider->getSignedInUser()['id'], $this->autorisationService::MODIF_CATALOGUE);
        if(!$granted){
            return $response->withStatus(302)->withHeader('Location', "/");
        }

        $token = CsrfService::generate();

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['csrf_token' => $token]);
    }
}
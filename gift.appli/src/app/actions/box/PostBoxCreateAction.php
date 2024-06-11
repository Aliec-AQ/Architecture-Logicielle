<?php
namespace gift\appli\app\actions\box;

use gift\appli\app\utils\CsrfService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;

use gift\appli\core\domain\entites\Box;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceNotFoundException;
use gift\appli\core\services\catalogue\CatalogueService;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;

use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\services\autorisation\AutorisationService;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\app\provider\authentification\AuthentificationProvider;

class PostBoxCreateAction extends \gift\appli\app\actions\AbstractAction 
{
    private BoxService $boxservice;
    private AuthentificationProviderInterface $provider;
    private AutorisationServiceInterface $autorisationService;

    public function __construct(){
        $this->boxservice = new BoxService();
        $this->provider = new AuthentificationProvider();
        $this->autorisationService = new AutorisationService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $granted = $this->autorisationService->isGranted($this->provider->getSignedInUser()['id'], $this->autorisationService::CREATE_BOX);
        if(!$granted){
            return $response->withStatus(302)->withHeader('Location', "/register");
        }

        $data = $request->getParsedBody();

        /* Récupération du token */
        $csrfToken = $data['_csrf_token'] ?? null;
        if (!$csrfToken) {
            throw new HttpBadRequestException($request, 'CSRF token manquant');
        }

        /* Vérification du token CSRF */
        try {
            CsrfService::check($csrfToken);
        } catch (\Exception $e) {
            throw new HttpBadRequestException($request, 'vérfication CSRF échouée');
        }

        /* Filtre des données */
        $formData = array_map(function($item) {
            return htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
        }, $data); 

        $formData['createur_id'] = $this->provider->getSignedInUser()['id'];

        try {
            $box = $this->boxservice->createBox($formData);
        } catch (BoxServiceNotFoundException $e) {
            throw new HttpBadRequestException($request, 'erreur création boîte');
        }

        $_SESSION['giftBox_box_courante'] = $box;

        return $response->withStatus(302)->withHeader('Location', "/boxs/courante/");
    }
}
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

use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\services\autorisation\AutorisationService;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\app\provider\authentification\AuthentificationProvider;

class PostPayBoxAction extends \gift\appli\app\actions\AbstractAction 
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
        /* Vérification paramètres */
        $id = $args['id'];

        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        $data = $request->getParsedBody();
        
        $granted = $this->autorisationService->isGranted($this->provider->getSignedInUser()['id'], $this->autorisationService::PAY_BOX, $id);
        if(!$granted){
            return $response->withStatus(302)->withHeader('Location', "/boxs/courante");
        }

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

        try {
            $box = $this->boxservice->payBox($id);
        } catch (BoxServiceNotFoundException $e) {
            throw new HttpBadRequestException($request, 'Erreur lors du paiement de la box');
        }

        return $response->withStatus(302)->withHeader('Location', "/boxs/courante/");
    }
}
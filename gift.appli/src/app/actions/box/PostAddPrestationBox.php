<?php
namespace gift\appli\app\actions\box;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Exception\HttpBadRequestException;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceInterface;
use gift\appli\core\services\box\BoxServiceNotFoundException;

use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\services\autorisation\AutorisationService;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\app\provider\authentification\AuthentificationProvider;


class PostAddPrestationBox extends \gift\appli\app\actions\AbstractAction
{
    private BoxServiceInterface $boxService;
    private AutorisationServiceInterface $autorisationService;
    private AuthentificationProviderInterface $provider;
    
    public function __construct(){
        $this->boxService = new BoxService();
        $this->autorisationService = new AutorisationService();
        $this->provider = new AuthentificationProvider();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $granted = $this->autorisationService->isGranted($this->provider->getSignedInUser()['id'], $this->autorisationService::MODIF_BOX, $_SESSION['giftBox_box_courante']);
        if(!$granted){
            return $response->withStatus(302)->withHeader('Location', "/box/create");
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
        $prestationId = htmlspecialchars($data['prestationId'], ENT_QUOTES, 'UTF-8');
        $boxId = $_SESSION['giftBox_box_courante'];


        try {
            $this->boxService->addPrestationToBox($prestationId, $boxId, $data['quantite']);
        } catch (BoxServiceNotFoundException $e) {
            throw new HttpBadRequestException($request, 'Ajout de la prestation échouée');
        }

        $url = "/listePrestations/";
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
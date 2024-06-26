<?php

namespace gift\appli\app\actions\box;

use gift\appli\app\utils\CsrfService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;
use gift\appli\core\domain\entites\Box;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceNotFoundException;
use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\services\autorisation\AutorisationService;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\app\provider\authentification\AuthentificationProvider;

class PostDefinirCouranteAction extends \gift\appli\app\actions\AbstractAction 
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

        $granted = $this->autorisationService->isGranted($this->provider->getSignedInUser()['id'], $this->autorisationService::MODIF_BOX, $id);
        if(!$granted){
            return $response->withStatus(302)->withHeader('Location', "/boxs/courante");
        }

        $_SESSION['giftBox_box_courante'] = $id;

        return $response->withStatus(302)->withHeader('Location', "/boxs/courante");
    }
}

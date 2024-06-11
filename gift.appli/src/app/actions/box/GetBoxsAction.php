<?php

namespace gift\appli\app\actions\box;

use gift\appli\app\actions\AbstractAction;
use gift\appli\app\provider\authentification\AuthentificationProvider;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\core\services\autorisation\AutorisationService;
use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceInterface;
use gift\appli\core\services\box\BoxServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class GetBoxsAction extends AbstractAction
{

    private string $template;
    private BoxServiceInterface $boxService;

    private AuthentificationProviderInterface $provider;



    public function __construct(){
        $this->template = 'BoxById.twig';
        $this->boxService = new BoxService();
        $this->provider = new AuthentificationProvider();
    }



    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if($this->provider->isSignedIn()){
            $user = $this->provider->getSignedInUser();
        } else {
            return $response->withStatus(302)->withHeader('Location', "/sign-in/");
        }


        try{
            $boxs = $this->boxService->getBoxByUserId($user['id']);
        } catch (BoxServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Boîtes non trouvées");

        }

        if(empty($boxs)){
            $boxs = null;
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'Boxs.twig', ['boxs' => $boxs]);
    }
}
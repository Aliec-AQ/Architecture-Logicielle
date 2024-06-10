<?php
namespace gift\appli\app\actions\box;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\box\BoxService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Views\Twig;

use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\services\autorisation\AutorisationService;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\app\provider\authentification\AuthentificationProvider;


class GetBoxCreateAction extends \gift\appli\app\actions\AbstractAction 
{
    private AuthentificationProviderInterface $provider;
    private AutorisationServiceInterface $autorisationService;

    private BoxService $boxService;

    public function __construct(){
        $this->provider = new AuthentificationProvider();
        $this->autorisationService = new AutorisationService();
        $this->boxService = new BoxService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $token = CsrfService::generate();

        $granted = $this->autorisationService->isGranted($this->provider->getSignedInUser()['id'], $this->autorisationService::CREATE_BOX);
        if(!$granted){
            return $response->withStatus(302)->withHeader('Location', "/register");
        }

        try {
            $predefinies = $this->boxService->getPredefinedBoxes();
        } catch (\Exception $e) {
            return $response->withStatus(500)->withHeader('Location', "/error");
        }

        $idPredefinie = $request->getQueryParams()['idPredefinie'] ?? null;



        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxCreate.twig', ['csrf_token' => $token, 'predefinies' => $predefinies, 'idPredefinie' => $idPredefinie ?? null]);
    }
}
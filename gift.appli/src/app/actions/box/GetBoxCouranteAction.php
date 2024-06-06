<?php
namespace gift\appli\app\actions\box;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

use gift\appli\core\services\box\BoxServiceInterface;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceNotFoundException;

use gift\appli\app\utils\CsrfService;

use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\services\autorisation\AutorisationService;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\app\provider\authentification\AuthentificationProvider;

class GetBoxCouranteAction extends \gift\appli\app\actions\AbstractAction 
{
    
    private string $template;
    private BoxServiceInterface $boxService;
    private AutorisationServiceInterface $autorisationService;
    private AuthentificationProviderInterface $provider;
    
    public function __construct(){
        $this->template = 'BoxCourante.twig';
        $this->boxService = new BoxService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        if(!isset($_SESSION['giftBox_box_courante'])){
            return $response->withStatus(302)->withHeader('Location', "/box/create/");
        }

        $id = $_SESSION['giftBox_box_courante'];

        try {
            $box = $this->boxService->getBoxById($id);
        } catch (BoxServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Box non trouvée dans la base de données");
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, $box);
    }
}
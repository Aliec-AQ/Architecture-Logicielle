<?php
namespace gift\api\app\actions\box;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

use gift\api\core\services\box\BoxServiceInterface;
use gift\api\core\services\box\BoxService;
use gift\api\core\services\box\BoxServiceNotFoundException;


class GetBoxCouranteAction extends \gift\api\app\actions\AbstractAction
{
    
    private string $template;
    private BoxServiceInterface $boxService;
    
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
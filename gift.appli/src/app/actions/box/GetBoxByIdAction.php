<?php

namespace gift\appli\app\actions\box;

use Carbon\AbstractTranslator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

use gift\appli\core\services\box\BoxServiceInterface;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceNotFoundException;

class GetBoxByIdAction extends \gift\appli\app\actions\AbstractAction
{

    private string $template;
    private BoxServiceInterface $boxService;
    
    public function __construct(){
        $this->template = 'BoxById.twig';
        $this->boxService = new BoxService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $request->getQueryParams()['id'] ?? null;
        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        if(isset($_SESSION['giftBox_box_courante']) && $_SESSION['giftBox_box_courante'] == $id){
            return $response->withHeader('Location', '/boxs/courante')->withStatus(302);
        }

        try{
            $box = $this->boxService->getBoxById($id);
        } catch (BoxServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Boîte non trouvée");
        }

        try {
            $isPredefinie = $this->boxService->isPredefinie($id);
        }catch (\Exception $e) {
            return $response->withStatus(500)->withHeader('Location', "/error");
        }

        if(!$isPredefinie){
            $uri= $request->getUri();
            $url = $uri->getScheme() . "://". $uri->getHost(). ":". $uri->getPort() . "/boxs/url/?box=".$box['token'];
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['box' => $box, 'estPredefinie' => $isPredefinie, 'url'=> $url ?? null]);
    }
}
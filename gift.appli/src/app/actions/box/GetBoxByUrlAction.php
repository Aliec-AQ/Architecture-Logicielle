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

class GetBoxByUrlAction extends \gift\appli\app\actions\AbstractAction
{

    private string $template;
    private BoxServiceInterface $boxService;
    
    public function __construct(){
        $this->template = 'BoxByUrl.twig';
        $this->boxService = new BoxService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $token = $request->getQueryParams()['box'] ?? null;

        if (is_null($token)) {
            throw new HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        try{
            $box = $this->boxService->getBoxByToken($token);
        } catch (BoxServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Boîte non trouvée");
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['box' => $box]);
    }
}
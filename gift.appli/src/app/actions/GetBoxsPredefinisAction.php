<?php

namespace gift\appli\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

use gift\appli\core\services\box\BoxServiceInterface;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceNotFoundException;

class GetBoxsPredefinisAction extends AbstractAction
{

    private string $template;
    private BoxServiceInterface $boxService;
    
    public function __construct(){
        $this->template = 'BoxById.twig';
        $this->boxService = new BoxService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        
        try{
            $boxsPredefinies = $this->boxService->getPredefinedBoxes();
        } catch (BoxServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Boîtes non trouvées");
        
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxsPredefinies.twig', ['boxsPredefinies' => $boxsPredefinies]);
    }
}
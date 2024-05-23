<?php
namespace gift\appli\app\actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use gift\appli\models\Prestation;

class GetPrestationAction extends AbstractAction 
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $request->getQueryParams()['id'] ?? null;


        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        try {
            $prestation = Prestation::findOrFail($id);
        } catch (\Exception $e) {
            throw new HttpNotFoundException($request, "Prestation non trouvée");
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'Prestation.twig', ['prestation' => $prestation]);
    }
}
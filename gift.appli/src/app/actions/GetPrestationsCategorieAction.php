<?php
namespace gift\appli\app\actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use gift\appli\models\Categorie;

class GetPrestationsCategorieAction extends AbstractAction 
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args['id'];

        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        try {
            $prestations = Categorie::findOrFail($id)->prestations;
        } catch (\Exception $e) {
            throw new HttpNotFoundException($request, "Catégorie non trouvée");
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'PrestationCategorie.twig', ['prestations' => $prestations, 'id' => $id]);
    }
}
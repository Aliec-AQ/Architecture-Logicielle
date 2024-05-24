<?php

namespace gift\appli\app\actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use gift\appli\models\Prestation;


class GetListePrestationsAction extends AbstractAction 
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $sort = $request->getQueryParams()['sort'] ?? null;
        $orderBy = [
            'alphabet_asc' => ['column' => 'libelle', 'direction' => 'asc'],
            'alphabet_desc' => ['column' => 'libelle', 'direction' => 'desc'],
            'price_asc' => ['column' => 'tarif', 'direction' => 'asc'],
            'price_desc' => ['column' => 'tarif', 'direction' => 'desc']
        ];

        if (array_key_exists($sort, $orderBy)) {
            $prestations = Prestation::with('categorie')->orderBy($orderBy[$sort]['column'], $orderBy[$sort]['direction'])->get();
        } else {
            $prestations = Prestation::with('categorie')->get();
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'ListePrestation.twig', ['prestations' => $prestations]);
    }
}

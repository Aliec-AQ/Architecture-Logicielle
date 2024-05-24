<?php

namespace gift\appli\app\actions;

use Carbon\AbstractTranslator;
use gift\appli\models\Box;
use gift\appli\models\Categorie;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class GetBoxByIdAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $request->getQueryParams()['id'] ?? null;
        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        try {
            $box = Box::findOrFail($id);
        } catch (\Exception $e) {
            throw new HttpNotFoundException($request, "Catégorie non trouvée");
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxById.twig', ['box' => $box]);
    }
}
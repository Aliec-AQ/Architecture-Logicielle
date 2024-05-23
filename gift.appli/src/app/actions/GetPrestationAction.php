<?php
namespace gift\appli\app\actions;

class GetPrestationAction extends \gift\appli\app\actions\AbstractAction 
{
    public function __invoke($request, $response, $args)
    {
        $id = $request->getQueryParams()['id'] ?? null;


        if ($id === null) {
            throw new \Slim\Exception\HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        $prestation = \gift\appli\models\Prestation::find($id);

        if ($prestation === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, "Prestation non trouvée");
        }

        $html = <<<HTML
            <h1>Prestation</h1>
            <p>ID : {$prestation->id}</p>
            <p>Libelle : {$prestation->libelle}</p>
            <p>Description : {$prestation->description}</p>
        HTML;

        $response->getBody()->write($html);
        return $response;
    }
}
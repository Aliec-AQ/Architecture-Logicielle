<?php
namespace gift\appli\app\actions;

class GetPrestationController
{
    public function __invoke($request, $response, $args)
    {
        $id = $request->getQueryParams()['id'] ?? null;

        if ($id === null) {
            $html = <<<HTML
            <h1>Error</h1>
            <p>ID manquant dans l'url : /prestations?id=xxx</p>
            HTML;
        } else {
            $html = <<<HTML
            <h1>Prestation Details</h1>
            <p>ID: {$id}</p>
            HTML;
        }

        $response->getBody()->write($html);
        return $response;
    }
}
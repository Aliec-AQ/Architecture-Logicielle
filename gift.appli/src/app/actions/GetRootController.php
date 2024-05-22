<?php
namespace gift\appli\app\actions;

class GetRootController
{
    public function __invoke($request, $response, $args)
    {
        $basePath = "/Architecture_Logicielle/Architecture-Logicielle/gift.appli/public";

        $html = <<<HTML
        <h1>Gift App</h1>
        <p><a href="$basePath/categories">Categories</a></p>
        <p><a href="$basePath/prestation">Prestations</a></p>
        <p><a href="$basePath/box/create">Create Box</a></p>
        HTML;

        $response->getBody()->write($html);
        return $response;
    }
}
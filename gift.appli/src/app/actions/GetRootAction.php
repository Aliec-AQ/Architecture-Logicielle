<?php
namespace gift\appli\app\actions;

class GetRootAction extends \gift\appli\app\actions\AbstractAction 
{
    public function __invoke($request, $response, $args)
    {
        $html = <<<HTML
        <h1>Gift App</h1>
        <p><a href="categories">Categories</a></p>
        <p><a href="prestation">Prestations</a></p>
        <p><a href="box/create">Create Box</a></p>
        HTML;

        $response->getBody()->write($html);
        return $response;
    }
}
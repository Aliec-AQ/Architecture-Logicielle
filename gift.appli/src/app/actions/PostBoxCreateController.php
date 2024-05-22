<?php
namespace gift\appli\app\actions;

class PostBoxCreateController
{
    public function __invoke($request, $response, $args)
    {
        $basePath = "/Architecture_Logicielle/Architecture-Logicielle/gift.appli/public";

        $html = <<<HTML
        <h1>Box Created</h1>
        <p>Form data:</p>
        <ul>
            <li>Name: {$postData['name']}</li>
            <li>Description: {$postData['description']}</li>
        </ul>
        HTML;

        $response->getBody()->write($html);
        return $response;
    }
}
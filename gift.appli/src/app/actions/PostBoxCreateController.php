<?php
namespace gift\appli\app\actions;

class PostBoxCreateController extends AbstractAction 
{
    public function __invoke($request, $response, $args)
    {
        $postData = $request->getParsedBody();
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
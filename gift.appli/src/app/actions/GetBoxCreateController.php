<?php
namespace gift\appli\app\actions;

class GetBoxCreateController
{
    public function __invoke($request, $response, $args)
    {
        $html = <<<HTML
        <h1>Create Box</h1>
        <form action="" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
            <label for="description">Description</label>
            <input type="text" id="description" name="description">
            <button type="submit">Create</button>
        </form>
        HTML;

        $response->getBody()->write($html);
        return $response;
    }
}
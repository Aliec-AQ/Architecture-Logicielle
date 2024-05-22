<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function( \Slim\App $app): \Slim\App {

    // utilisé pour récupérer le chemin de base de l'application (car dans un sous-dossier)
    global $app;

    // route globale pour accéder rapidement aux différentes pages
    $app->get('/', function (Request $request, Response $response) use ($app) {
        $basePath = $app->getBasePath();

        $html = <<<HTML
        <h1>Gift App</h1>
        <p><a href="$basePath/categories">Categories</a></p>
        <p><a href="$basePath/prestation">Prestations</a></p>
        <p><a href="$basePath/box/create">Create Box</a></p>
        HTML;

        $response->getBody()->write($html);
        return $response;
    });


    $app->get('/categories', function (Request $request, Response $response) use ($app) {
        $categories = [
            ['id' => 1, 'name' => 'Category 1'],
            ['id' => 2, 'name' => 'Category 2'],
            ['id' => 3, 'name' => 'Category 3']
        ];

        $basePath = $app->getBasePath();

        $html = <<<HTML
        <h1>Categories</h1>
        HTML;
        foreach ($categories as $category) {
            $url = $basePath . '/categorie/' . $category['id'];
            $html .= <<<HTML
            <p><a href="$url">ID: {$category['id']}, Name: {$category['name']}</a></p>
            HTML;
        }

        $response->getBody()->write($html);
        return $response;
    });

    $app->get('/categorie/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];
        $categories = [
            ['id' => 1, 'name' => 'Category 1'],
            ['id' => 2, 'name' => 'Category 2'],
            ['id' => 3, 'name' => 'Category 3']
        ];

        $category = array_filter($categories, function($cat) use ($id) {
            return $cat['id'] == $id;
        });

        if (empty($category)) {
            $response->getBody()->write("Category not found");
            return $response->withStatus(404);
        }

        $category = array_shift($category);

        $html = <<<HTML
        <h1>Category</h1>
        <p>ID: {$category['id']}, Name: {$category['name']}</p>
        HTML;

        $response->getBody()->write($html);
        return $response;
    });

    $app->get('/prestation', function (Request $request, Response $response) {
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
    });

    $app->get('/box/create', function (Request $request, Response $response) use ($app) {

        $basePath = $app->getBasePath();

        $html = <<<HTML
        <h1>Create Box</h1>
        <form action="$basePath/box/create" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
            <label for="description">Description</label>
            <input type="text" id="description" name="description">
            <button type="submit">Create</button>
        </form>
        HTML;

        $response->getBody()->write($html);
        return $response;
    });

    $app->post('/box/create', function (Request $request, Response $response) {
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
    });

    return $app;
};
<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function( \Slim\App $app): \Slim\App {

    // route globale pour accéder rapidement aux différentes pages
    $app->get('/', gift\appli\app\actions\GetRootController::class);

    $app->get('/categories[/]', gift\appli\app\actions\GetCategorieController::class);

    $app->get('/categorie/{id}[/]', gift\appli\app\actions\GetCategorieIdController::class);

    $app->get('/categorie/{id}/prestations[/]', gift\appli\app\actions\GetPrestationsCategorieController::class);

    $app->get('/prestation[/]', gift\appli\app\actions\GetPrestationController::class);

    $app->get('/box/create[/]', gift\appli\app\actions\GetBoxCreateController::class);

    $app->post('/box/create[/]', gift\appli\app\actions\PostBoxCreateController::class);

    return $app;
};
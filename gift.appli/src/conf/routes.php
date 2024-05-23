<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function( \Slim\App $app): \Slim\App {

    // route globale pour accéder rapidement aux différentes pages
    $app->get('/', gift\appli\app\actions\GetRootAction::class)->setName('root');

    $app->get('/categories[/]', gift\appli\app\actions\GetCategorieAction::class)->setName('categories');

    $app->get('/categorie/{id}[/]', gift\appli\app\actions\GetCategorieIdAction::class)->setName('categorieById');

    $app->get('/categorie/{id}/prestations[/]', gift\appli\app\actions\GetPrestationsCategorieAction::class)->setName('prestationsCategorie');

    $app->get('/prestation[/]', gift\appli\app\actions\GetPrestationAction::class)->setName('prestation');

    $app->get('/box/create[/]', gift\appli\app\actions\GetBoxCreateAction::class)->setName('boxCreate');

    $app->post('/box/create[/]', gift\appli\app\actions\PostBoxCreateAction::class)->setName('boxCreatePost');

    return $app;
};
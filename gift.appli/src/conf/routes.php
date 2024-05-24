<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use gift\appli\app\actions\GetRootAction;
use gift\appli\app\actions\GetCategorieAction;
use gift\appli\app\actions\GetCategorieIdAction;
use gift\appli\app\actions\GetPrestationsCategorieAction;
use gift\appli\app\actions\GetPrestationAction;
use gift\appli\app\actions\GetBoxCreateAction;
use gift\appli\app\actions\PostBoxCreateAction;

return function( App $app): App {

    // route globale pour accéder rapidement aux différentes pages
    $app->get('/', GetRootAction::class)->setName('root');

    $app->get('/categories[/]', GetCategorieAction::class)->setName('categories');

    $app->get('/categorie/{id}[/]', GetCategorieIdAction::class)->setName('categorieById');

    $app->get('/categorie/{id}/prestations[/]', GetPrestationsCategorieAction::class)->setName('prestationsCategorie');

    $app->get('/prestation[/]', GetPrestationAction::class)->setName('prestation');

    $app->get('/prestations[/]', GetPrestationAction::class)->setName('prestations');

    $app->get('/box/create[/]', GetBoxCreateAction::class)->setName('boxCreate');

    $app->post('/box/create[/]', PostBoxCreateAction::class)->setName('boxCreatePost');

    $app->get('/box[/]', GetBoxCreateAction::class)->setName('box');


    return $app;
};
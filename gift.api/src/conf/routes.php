<?php
declare(strict_types=1);

use gift\api\app\actions\box\GetBoxByIdAction;
use gift\api\app\actions\catalogue\GetCategorieAction;
use gift\api\app\actions\catalogue\GetCategorieIdAction;
use gift\api\app\actions\catalogue\GetListePrestationsAction;
use gift\api\app\actions\catalogue\GetPrestationAction;
use gift\api\app\actions\catalogue\GetPrestationsCategorieAction;
use Slim\App;


return function( App $app): App {
    /* ROUTES CATEGORIE */

    $app->get('/api/categories[/]', GetCategorieAction::class)->setName('categories');
    $app->get('/api/categories/{id}[/]', GetCategorieIdAction::class)->setName('categorieId');

    $app->get('/api/prestations[/]', GetListePrestationsAction::class)->setName('prestations');
    $app->get('/api/prestations/{id}[/]', GetPrestationAction::class)->setName('prestationId');

    $app->get('/api/categories/{id}/prestations[/]', GetPrestationsCategorieAction::class)->setName('prestationsCategorie');
    $app->get('/api/boxes/{id}[/]', GetBoxByIdAction::class)->setName('boxById');

    return $app;
};
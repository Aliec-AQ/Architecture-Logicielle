<?php
declare(strict_types=1);

use gift\appli\app\actions\GetBoxByIdAction;
use gift\appli\app\actions\GetBoxsPredefinisAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use gift\appli\app\actions\GetRootAction;
use gift\appli\app\actions\GetCategorieAction;
use gift\appli\app\actions\GetCategorieIdAction;
use gift\appli\app\actions\GetPrestationsCategorieAction;
use gift\appli\app\actions\GetListePrestationsAction;
use gift\appli\app\actions\GetPrestationAction;
use gift\appli\app\actions\GetBoxCreateAction;
use gift\appli\app\actions\PostBoxCreateAction;
use gift\appli\app\actions\GetCategorieCreateAction;
use gift\appli\app\actions\PostCategorieCreateAction;
use gift\appli\app\actions\PostAddPrestationBox;

return function( App $app): App {

    /* ROUTE ROOT */

    $app->get('/', GetRootAction::class)->setName('root');

    /* ROUTES CATEGORIE */

    $app->get('/categorie/create[/]', GetCategorieCreateAction::class)->setName('categorieCreate');
    $app->post('/categorie/create[/]', PostCategorieCreateAction::class)->setName('categorieCreatePost');
    $app->get('/categories[/]', GetCategorieAction::class)->setName('categories');
    $app->get('/categorie/{id}[/]', GetCategorieIdAction::class)->setName('categorieById');
    $app->get('/categorie/{id}/prestations[/]', GetPrestationsCategorieAction::class)->setName('prestationsCategorie');

    /* ROUTES PRESTATION */

    $app->get('/prestation[/]', GetPrestationAction::class)->setName('prestation');
    $app->get('/listePrestations[/]', GetListePrestationsAction::class)->setName('listePrestations');

    /* ROUTES BOX */

    $app->get('/box/create[/]', GetBoxCreateAction::class)->setName('boxCreate');
    $app->post('/box/create[/]', PostBoxCreateAction::class)->setName('boxCreatePost');
    $app->get('/box[/]', GetBoxByIdAction::class)->setName('box');
    $app->get('/boxsPredefinies[/]', GetBoxsPredefinisAction::class)->setName('boxsPredefinies');
    $app->post('/box/addPrestation[/]', PostAddPrestationBox::class)->setName('addPrestationToBox');

    return $app;
};
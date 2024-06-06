<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

use gift\appli\app\actions\GetRootAction;
use gift\appli\app\actions\catalogue\GetCategorieAction;
use gift\appli\app\actions\catalogue\GetCategorieIdAction;
use gift\appli\app\actions\catalogue\GetPrestationsCategorieAction;
use gift\appli\app\actions\catalogue\GetListePrestationsAction;
use gift\appli\app\actions\catalogue\GetPrestationAction;
use gift\appli\app\actions\catalogue\GetCategorieCreateAction;
use gift\appli\app\actions\catalogue\PostCategorieCreateAction;

use gift\appli\app\actions\box\GetBoxCreateAction;
use gift\appli\app\actions\box\PostBoxCreateAction;
use gift\appli\app\actions\box\PostAddPrestationBox;
use gift\appli\app\actions\box\GetBoxCouranteAction;
use gift\appli\app\actions\box\GetBoxByIdAction;
use gift\appli\app\actions\box\GetBoxsPredefinisAction;

use gift\appli\app\actions\user\GetRegisterFormAction;
use gift\appli\app\actions\user\PostRegisterFormAction;
use gift\appli\app\actions\user\GetSignInAction;
use gift\appli\app\actions\user\PostSignInAction;

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
    $app->get('/box/courante[/]', GetBoxCouranteAction::class)->setName('boxCourante');

    $app->post('/box/removePrestation/{id}[/]', GetBoxCouranteAction::class);

    /* ROUTES USER */

    $app->get('/register[/]', GetRegisterFormAction::class)->setName('register');
    $app->post('/register[/]', PostRegisterFormAction::class)->setName('registerPost');
    $app->get('/signIn[/]', GetSignInAction::class)->setName('signIn');
    $app->post('/signIn[/]', PostSignInAction::class)->setName('signInPost');

    return $app;
};
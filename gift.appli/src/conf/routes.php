<?php
declare(strict_types=1);

use gift\appli\app\actions\box\GetBoxsAction;
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
use gift\appli\app\actions\catalogue\GetPrestationUpdateAction;
use gift\appli\app\actions\catalogue\PostPrestationUpdateAction;

use gift\appli\app\actions\box\GetBoxCreateAction;
use gift\appli\app\actions\box\PostBoxCreateAction;
use gift\appli\app\actions\box\PostAddPrestationBox;
use gift\appli\app\actions\box\GetBoxCouranteAction;
use gift\appli\app\actions\box\GetBoxByIdAction;
use gift\appli\app\actions\box\GetBoxsPredefinisAction;
use gift\appli\app\actions\box\PostRemovePrestationBoxAction;
use gift\appli\app\actions\box\PostUpdateQuantiteBoxAction;
use gift\appli\app\actions\box\PostValidateBoxAction;
use gift\appli\app\actions\box\PostPayBoxAction;
use gift\appli\app\actions\box\GetBoxByUrlAction;
use gift\appli\app\actions\box\PostGenerateBoxUrlAction;
use gift\appli\app\actions\box\PostDefinirCouranteAction;

use gift\appli\app\actions\user\GetRegisterFormAction;
use gift\appli\app\actions\user\PostRegisterFormAction;
use gift\appli\app\actions\user\GetSignInAction;
use gift\appli\app\actions\user\PostSignInAction;

return function( App $app): App {

    /* ROUTE ROOT */

    $app->get('/', GetRootAction::class)->setName('root');

    /* ROUTES CATEGORIE */

    $app->get('/categories/create[/]', GetCategorieCreateAction::class)->setName('categorieCreate');
    $app->get('/categories[/]', GetCategorieAction::class)->setName('categories');
    $app->get('/categories/{id}[/]', GetCategorieIdAction::class)->setName('categorieById');
    $app->get('/categories/{id}/prestations[/]', GetPrestationsCategorieAction::class)->setName('prestationsCategorie');

    $app->post('/categories/create[/]', PostCategorieCreateAction::class)->setName('categorieCreatePost');

    /* ROUTES PRESTATION */

    $app->get('/prestations/liste[/]', GetListePrestationsAction::class)->setName('listePrestations');
    $app->get('/prestations[/]', GetPrestationAction::class)->setName('prestation');
    $app->get('/prestations/{id}/update[/]', GetPrestationUpdateAction::class)->setName('prestationUpdate');

    $app->post('/prestations/{id}/update[/]', PostPrestationUpdateAction::class)->setName('prestationUpdatePost');
    
    /* ROUTES BOX */

    $app->get('/boxs/courante[/]', GetBoxCouranteAction::class)->setName('boxCourante');
    $app->get('/boxs/create[/]', GetBoxCreateAction::class)->setName('boxCreate');
    $app->get('/boxs/predefinies[/]', GetBoxsPredefinisAction::class)->setName('boxsPredefinies');
    $app->get('/boxs/liste[/]', GetBoxsAction::class)->setName('boxs');
    $app->get('/boxs[/]', GetBoxByIdAction::class)->setName('box');
    $app->get('/boxs/url[/]', GetBoxByUrlAction::class)->setName('boxUrl');

    $app->post('/boxs/courante/prestations/{id-presta}/add[/]', PostAddPrestationBox::class)->setName('addPrestationToBox');
    $app->post('/boxs/create[/]', PostBoxCreateAction::class)->setName('boxCreatePost');
    $app->post('/boxs/{id}/prestations/{id-presta}/remove[/]', PostRemovePrestationBoxAction::class)->setName('removePrestationToBox');
    $app->post('/boxs/{id}/prestations/{id-presta}/update-quantite[/]', PostUpdateQuantiteBoxAction::class)->setName('updateQuantiteToBox');
    $app->post('/boxs/{id}/validate[/]', PostValidateBoxAction::class)->setName('validateBox');
    $app->post('/boxs/{id}/pay[/]', PostPayBoxAction::class)->setName('payBox');
    $app->post('/boxs/{id}/generate-url[/]', PostGenerateBoxUrlAction::class)->setName('generateUrlBox');
    $app->post('/boxs/{id}/definir-courante[/]', PostDefinirCouranteAction::class)->setName('definirCourante');

    /* ROUTES USER */

    $app->get('/register[/]', GetRegisterFormAction::class)->setName('register');
    $app->get('/sign-in[/]', GetSignInAction::class)->setName('signIn');

    $app->post('/sign-in[/]', PostSignInAction::class)->setName('signInPost');
    $app->post('/register[/]', PostRegisterFormAction::class)->setName('registerPost');

    return $app;
};
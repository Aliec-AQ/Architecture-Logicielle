<?php
declare(strict_types=1);

gift\appli\app\utils\Eloquent::init(__DIR__ . '/gift.db.conf.ini.dist');

/* application bootstrap */

$app = \Slim\Factory\AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

/* Config Twig */

$twig = \Slim\Views\Twig::create(__DIR__ . '/../app/views', ['cache' => false]);
$app->add(\Slim\Views\TwigMiddleware::create($app, $twig)); 

$app=(require_once __DIR__ . '/routes.php')($app);

return $app;
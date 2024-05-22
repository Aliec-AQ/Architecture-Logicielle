<?php
declare(strict_types=1);

gift\appli\app\utils\Eloquent::init(__DIR__ . '/gift.db.conf.ini.dist');

/* application bootstrap */

// variable pour mettre le chemin de base de l'application (car dans un sous-dossier)
$basePath = "/Architecture_Logicielle/Architecture-Logicielle/gift.appli/public/";

$app = \Slim\Factory\AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app->setBasePath($basePath);

$app=(require_once __DIR__ . '/routes.php')($app);

return $app;
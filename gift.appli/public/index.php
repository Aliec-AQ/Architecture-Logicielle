<?php
declare(strict_types=1);



require_once __DIR__ . '/../src/vendor/autoload.php';

gift\appli\app\utils\Eloquent::init(__DIR__ . '/../src/conf/gift.db.conf.ini.dist');

/* application boostrap */

// variable pour mettre le chemin de base de l'application (car dans un sous-dossier)
$basePath = "/Architecture_Logicielle/Architecture-Logicielle/gift.appli/public";


$app = \Slim\Factory\AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app->setBasePath($basePath);

$app=(require_once __DIR__ . '/../src/conf/routes.php')($app);

$app->run();
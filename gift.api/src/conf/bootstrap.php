<?php
declare(strict_types=1);

gift\api\infrastructure\Eloquent::init(__DIR__ . '/gift.db.conf.ini.dist');

/* application bootstrap */

session_start();

$app = \Slim\Factory\AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, false, false);

$app=(require_once __DIR__ . '/routes.php')($app);

return $app;
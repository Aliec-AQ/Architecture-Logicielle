<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Response;

gift\api\infrastructure\Eloquent::init(__DIR__ . '/gift.db.conf.ini.dist');

/* api bootstrap */

session_start();

$app = \Slim\Factory\AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, false, false);

$errorMiddleware->setErrorHandler(
    HttpNotFoundException::class,
    function (ServerRequestInterface $request) {
        $response = new Response();
        $response->getBody()->write(json_encode([
            'type' => 'error',
            'code' => '404',
            'message' => 'Ressource non trouvée',
            'description' => 'La ressource demandée n\'existe pas ou plus'
            ]));
        return $response->withStatus(404);
    }
);

$app=(require_once __DIR__ . '/routes.php')($app);

return $app;
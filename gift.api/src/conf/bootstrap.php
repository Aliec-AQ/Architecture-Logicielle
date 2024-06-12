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

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});


$app=(require_once __DIR__ . '/routes.php')($app);

return $app;
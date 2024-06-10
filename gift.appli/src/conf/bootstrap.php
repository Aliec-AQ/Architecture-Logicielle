<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use Slim\Psr7\Response as SlimResponse;

gift\appli\infrastructure\Eloquent::init(__DIR__ . '/gift.db.conf.ini.dist');

/* application bootstrap */

session_start();

$app = \Slim\Factory\AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

/* Config Twig */

$twig = \Slim\Views\Twig::create(__DIR__ . '/../app/views', ['cache' => false]);
$app->add(\Slim\Views\TwigMiddleware::create($app, $twig)); 

$errorMiddleware = $app->addErrorMiddleware(true, false, false);
/*
$errorMiddleware->setDefaultErrorHandler(
    function (Request $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails) use ($twig) {
        $statusCode = $exception->getCode();
        $errorMessage = $exception->getMessage();

        $response = new SlimResponse();

        return $twig->render($response, 'Error.twig', [
            'statusCode' => $statusCode,
            'errorMessage' => $errorMessage,
        ]);
    }
);*/

$app=(require_once __DIR__ . '/routes.php')($app);

return $app;
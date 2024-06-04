<?php
namespace gift\api\app\actions\box;

use gift\appli\app\utils\CsrfService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\api\app\actions\AbstractAction;
use Slim\Views\Twig;


class GetBoxCreateAction extends AbstractAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $token = CsrfService::generate();


        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxCreate.twig', ['csrf_token' => $token]);
    }
}
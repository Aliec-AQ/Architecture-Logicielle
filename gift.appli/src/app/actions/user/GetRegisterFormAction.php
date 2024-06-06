<?php
namespace gift\appli\app\actions\user;

use gift\appli\app\utils\CsrfService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Views\Twig;


class GetRegisterFormAction extends \gift\appli\app\actions\AbstractAction 
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $token = CsrfService::generate();

        $view = Twig::fromRequest($request);
        return $view->render($response, 'UserRegister.twig', ['csrf_token' => $token]);
    }
}
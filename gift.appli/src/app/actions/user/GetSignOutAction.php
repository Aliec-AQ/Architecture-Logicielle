<?php
namespace gift\appli\app\actions\user;

use gift\appli\app\utils\CsrfService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;

use gift\appli\app\provider\authentification\AuthentificationProvider;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;

class GetSignOutAction extends \gift\appli\app\actions\AbstractAction 
{
    private AuthentificationProviderInterface $provider;

    public function __construct(){
        $this->provider = new AuthentificationProvider();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        $this->provider->signOut();

        return $response->withStatus(302)->withHeader('Location', "/");
    }
}
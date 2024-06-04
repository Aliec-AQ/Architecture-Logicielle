<?php
namespace gift\appli\app\actions\catalogue;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Views\Twig;

use gift\appli\app\utils\CsrfService;

class GetCategorieCreateAction extends \gift\appli\app\actions\AbstractAction
{

    private string $template;
    
    public function __construct(){
        $this->template = 'CategorieCreate.twig';
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $token = CsrfService::generate();

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['csrf_token' => $token]);
    }
}
<?php
namespace gift\api\app\actions\catalogue;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\api\app\actions\AbstractAction;
use Slim\Views\Twig;

use gift\api\app\utils\CsrfService;

class GetCategorieCreateAction extends \gift\api\app\actions\AbstractAction
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
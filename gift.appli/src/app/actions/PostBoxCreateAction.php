<?php
namespace gift\appli\app\actions;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\domain\entites\Box;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceNotFoundException;
use gift\appli\core\services\catalogue\CatalogueService;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;

class PostBoxCreateAction extends AbstractAction 
{
    private string $template;
    private BoxService $boxservice;

    public function __construct(){
        $this->template = 'BoxCreatePost.twig';
        $this->boxservice = new BoxService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        foreach ($data as $key => $value) {
            echo $key . ' => ' . $value . '<br>';
        }

        /* Récupération du token */
        $csrfToken = $data['_csrf_token'] ?? null;
        if (!$csrfToken) {
            throw new HttpBadRequestException($request, 'CSRF token manquant');
        }

        /* Vérification du token CSRF */
        try {
            CsrfService::check($csrfToken);
        } catch (\Exception $e) {
            throw new HttpBadRequestException($request, 'vérfication CSRF échouée');
        }

        /* Filtre des données */
        $formData = array_map(function($item) {
            return htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
        }, $data);

        try {
            $box = $this->boxservice->createBox($formData);
        } catch (BoxServiceNotFoundException $e) {
            throw new HttpBadRequestException($request, 'Création de la catégorie échouée');
        }

        $_SESSION['giftBox_box_courante'] = $csrfToken;

        $view = Twig::fromRequest($request);
        return $response->withStatus(302)->withHeader('Location', "/");
    }
}
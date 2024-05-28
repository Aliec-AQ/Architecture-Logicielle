<?php
namespace gift\appli\app\actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use gift\appli\app\actions\AbstractAction;
use Slim\Exception\HttpBadRequestException;

use gift\appli\app\utils\CsrfService;
use gift\appli\core\services\catalogue\CatalogueService;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;
use gift\appli\core\services\catalogue\CatalogueServiceArgumentException;

class PostCategorieCreateAction extends AbstractAction
{

    private string $template;
    private CatalogueServiceInterface $catalogueService;
    
    public function __construct(){
        $this->template = 'CategorieCreatePost.twig';
        $this->catalogueService = new CatalogueService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();

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
        $formData = [
            'libelle' => htmlspecialchars($data['libelle'] ?? '', ENT_QUOTES, 'UTF-8'),
            'description' => htmlspecialchars($data['description'] ?? '', ENT_QUOTES, 'UTF-8')
        ];

        try {
            $categorie = $this->catalogueService->createCategorie($formData);
        } catch (CatalogueServiceNotFoundException $e) {
            throw new HttpBadRequestException($request, 'Création de la catégorie échouée');
        }

        $url = "/categories";
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
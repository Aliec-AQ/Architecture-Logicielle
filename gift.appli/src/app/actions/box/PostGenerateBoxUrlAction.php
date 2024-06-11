<?php

namespace gift\appli\app\actions\box;

use gift\appli\app\utils\CsrfService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;
use gift\appli\core\domain\entities\Box;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceNotFoundException;
use gift\appli\core\services\authorization\AuthorizationServiceInterface;
use gift\appli\core\services\authorization\AuthorizationService;
use gift\appli\app\provider\authentication\AuthenticationProviderInterface;
use gift\appli\app\provider\authentication\AuthenticationProvider;

class PostGenerateBoxUrlAction extends \gift\appli\app\actions\AbstractAction 
{
    private BoxService $boxService;
    private AuthenticationProviderInterface $provider;
    private AuthorizationServiceInterface $authorizationService;

    public function __construct()
    {
        $this->boxService = new BoxService();
        $this->provider = new AuthenticationProvider();
        $this->authorizationService = new AuthorizationService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        /* Check parameters */
        $id = $args['id'];

        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Parameter missing in the URL");
        }

        $data = $request->getParsedBody();

        $granted = $this->authorizationService->isGranted($this->provider->getSignedInUser()['id'], AuthorizationService::MODIF_BOX, $id);
        if (!$granted) {
            return $response->withStatus(302)->withHeader('Location', "/boxs/courante");
        }

        /* Retrieve the CSRF token */
        $csrfToken = $data['_csrf_token'] ?? null;
        if (!$csrfToken) {
            throw new HttpBadRequestException($request, 'Missing CSRF token');
        }

        /* Verify the CSRF token */
        try {
            CsrfService::check($csrfToken);
        } catch (\Exception $e) {
            throw new HttpBadRequestException($request, 'CSRF verification failed');
        }

        try {
            $box = $this->boxService->generateUrl($id, $csrfToken);
        } catch (BoxServiceNotFoundException $e) {
            throw new HttpBadRequestException($request, 'Error generating the box URL: ' . $e->getMessage());
        }

        $url = "/boxs/" . $box->token . "/url/";

        // Redirect the user to the URL
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}

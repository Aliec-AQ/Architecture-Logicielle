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
use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\services\autorisation\AutorisationService;
use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\app\provider\authentification\AuthentificationProvider;

class PostGenerateBoxUrlAction extends \gift\appli\app\actions\AbstractAction 
{
    private BoxService $boxService;
    private AuthentificationProviderInterface $provider;
    private AutorisationServiceInterface $autorisationService;

    public function __construct()
    {
        $this->boxService = new BoxService();
        $this->provider = new AuthentificationProvider();
        $this->autorisationService = new AutorisationService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        /* Check parameters */
        $id = $args['id'];

        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Parameter missing in the URL");
        }

        $data = $request->getParsedBody();

        $granted = $this->autorisationService->isGranted($this->provider->getSignedInUser()['id'], AutorisationService::PAY_BOX, $id);
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

        $uri= $request->getUri();
        $url = $uri->getScheme() . "://". $uri->getHost(). ":". $uri->getPort() . "/boxs/url/?box=".urlencode($box['token']);

        // Redirect the user to the URL
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}

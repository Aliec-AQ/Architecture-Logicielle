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

class PostSignInAction extends \gift\appli\app\actions\AbstractAction 
{
    private AuthentificationProviderInterface $provider;

    public function __construct(){
        $this->provider = new AuthentificationProvider();
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

        $email = htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8');

        $error = $this->provider->signIn($email, $data['password']);
        if ($error) {
            $token = CsrfService::generate();
            $view = Twig::fromRequest($request);
            return $view->render($response, 'UserSignIn.twig', ['error' => $error, 'csrf_token' => $token]);
        }

        return $response->withStatus(302)->withHeader('Location', "/box/courante/");
    }
}
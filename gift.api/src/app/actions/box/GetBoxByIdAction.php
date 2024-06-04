<?php

namespace gift\api\app\actions\box;

use Carbon\AbstractTranslator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

use gift\api\core\services\box\BoxServiceInterface;
use gift\api\core\services\box\BoxService;
use gift\api\core\services\box\BoxServiceNotFoundException;

class GetBoxByIdAction extends \gift\api\app\actions\AbstractAction
{

    private BoxServiceInterface $boxService;
    
    public function __construct(){
        $this->boxService = new BoxService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args['id'];
        if (is_null($id)) {
            throw new HttpBadRequestException($request, "Paramètre absent dans l'URL");
        }

        try{
            $box = $this->boxService->getBoxById($id);
        } catch (BoxServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Boîte non trouvée");
        }


        $prestationsArray = [];
        foreach ($box['prestations'] as $prestation) {
            $prestationsArray[] = [
                'prestation' => [
                    'id' => $prestation['id'],
                    'libelle' => $prestation['libelle'],
                    'description' => $prestation['description'],
                    'unite' => $prestation['unite'],
                    'tarif' => $prestation['tarif'],
                    'img' => $prestation['img'],
                    'cat_id' => $prestation['cat_id']
                ],
                'links' => [
                    'self' => [
                        'href' => "/api/prestations/" . $prestation['id'] . "/"
                    ]
                ]
            ];
        }

        $data = [
            'type' => 'ressource',
            'box' => [
                'id' => $box['id'],
                'token' => $box['token'],
                'libelle' => $box['libelle'],
                'description' => $box['description'],
                'montant' => $box['montant'],
                'kdo' => $box['kdo'],
                'message_kdo' => $box['message_kdo'],
                'statut' => $box['statut'],
                'created_at' => $box['created_at'],
                'updated_at' => $box['updated_at'],
                'createur_id' => $box['createur_id'],
                'prestations' => $prestationsArray,
            ]
        ];

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
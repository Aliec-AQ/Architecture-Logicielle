<?php
namespace gift\appli\core\services\box;

use gift\appli\core\services\box\BoxServiceInterface;
use gift\appli\core\services\box\BoxServiceNotFoundException;

use gift\appli\core\domain\entites\Box;

/**
 * Service de gestion des boîtes.
 */
class BoxService implements BoxServiceInterface {
    
    /**
     * Récupère une boîte par son identifiant.
     *
     * @param string $id L'identifiant de la boîte.
     * @return array Les données de la boîte.
     * @throws BoxServiceNotFoundException Si la boîte n'est pas trouvée dans la base de données.
     */
    public function getBoxById(string $id): array {
        try{
            $box = Box::findOrFail($id);
            return $box->toArray();
        } catch (BoxServiceNotFoundException $e) {
            throw new BoxServiceNotFoundException("Échec de la récupération de la box depuis la base de données.");
        }
    }

    /**
     * Récupère toutes les boîtes.
     *
     * @return array Les données de toutes les boîtes.
     * @throws BoxServiceNotFoundException Si les boîtes ne sont pas trouvées dans la base de données.
     */
    public function getBoxes(): array {
        try{
            $boxes = Box::all();
            return $boxes->toArray();
        } catch (BoxServiceNotFoundException $e) {
            throw new BoxServiceNotFoundException("Échec de la récupération des boxes depuis la base de données.");
        }
    }

    /**
     * Récupère les boîtes prédéfinies.
     *
     * @return array Les données des boîtes prédéfinies.
     * @throws BoxServiceNotFoundException Si les boîtes prédéfinies ne sont pas trouvées dans la base de données.
     */
    public function getPredefinedBoxes(): array {
        try{
            $boxes = Box::where('statut',"=", 5)->get();
            return $boxes->toArray();
        } catch (BoxServiceNotFoundException $e) {
            throw new BoxServiceNotFoundException("Échec de la récupération des boxes prédéfinis depuis la base de données.");
        }
    }
}
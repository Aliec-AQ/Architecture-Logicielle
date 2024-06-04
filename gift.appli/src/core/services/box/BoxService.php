<?php
namespace gift\appli\core\services\box;

use gift\appli\core\services\box\BoxServiceInterface;
use gift\appli\core\services\box\BoxServiceNotFoundException;

use gift\appli\core\domain\entites\Box;
use gift\appli\core\domain\entites\Prestation;

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
            $box = Box::with('prestations')->findOrFail($id);
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

    /**
     * Crée une boîte.
     *
     * @param array $data Les données de la boîte.
     * @return string L'identifiant de la boîte créée.
     * @throws BoxServiceNotFoundException Si la boîte n'a pas pu être créée.
     */
    public function createBox(array $data): string {

        try {

            $name = $data['name'];
            $description = $data['description'];
            $message_kdo = $data['kdo_message'] ?? '';

            $filteredName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            $filteredDescription = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
            $filteredMessageKdo = htmlspecialchars($message_kdo, ENT_QUOTES, 'UTF-8');

            if ($name !== $filteredName || $description !== $filteredDescription || $message_kdo !== $filteredMessageKdo) {
                echo "probleme";
                throw new \Exception("Données de catégorie invalides.");
            }

            $box = new Box();
            $box->token = $data['_csrf_token'];
            $box->libelle = $data['name'];
            $box->description = $data['description'];
            $box->montant = 0;
            $box->kdo = isset($data['kdo']) ? 1 : 0;
            $box->statut = 1;
            $box->message_kdo = $data['kdo_message'];
            $box->save();
            return $box->id;
        }catch (\Exception){
            throw new BoxServiceNotFoundException();
        }

    }

    /**
     * Ajoute une prestation à un coffret.
     *
     * @param string $prestationId L'identifiant de la prestation.
     * @param string $boxId L'identifiant du coffret.
     * @throws BoxServiceNotFoundException Si le coffret ou la prestation n'est pas trouvée dans la base de données.
     */
    public function addPrestationToBox(string $prestationId, string $boxId, int $quantite): void {
        try{
            if(is_null($prestationId) || is_null($boxId)){
                throw new BoxServiceNotFoundException("Échec de l'ajout de la prestation au coffret.");
            }

            $box = Box::findOrFail($boxId);
            $prestation = Prestation::findOrFail($prestationId);
            
            // check si la prestation est déjà dans le coffret
            $existingPrestation = $box->prestations()->where('presta_id', $prestationId)->first();

            if ($existingPrestation) {
                // met à jour la quantité de la prestation
                $existingPrestation->pivot->quantite += $quantite;
                $existingPrestation->pivot->save();
            } else {
                // ajoute la prestation au coffret
                $box->prestations()->attach($prestation, ['quantite' => $quantite]);
            }

            // met à jour le montant du coffret
            $totalMontant = 0;
            foreach ($box->prestations as $prestation) {
                $totalMontant += $prestation->pivot->quantite * $prestation->tarif;
            }
            $box->montant = $totalMontant;

            $box->save();
        } catch (BoxServiceNotFoundException $e) {
            throw new BoxServiceNotFoundException("Échec de l'ajout de la prestation au coffret.");
        }
    }
}
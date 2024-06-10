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
        } catch (\Exception $e) {
            throw new BoxServiceNotFoundException("Échec de la récupération de la box depuis la base de données.");
        }
    }

    /**
     * Récupère une boîte par son token.
     *
     * @param string $token Le token de la boîte.
     * @return array Les données de la boîte.
     * @throws BoxServiceNotFoundException Si la boîte n'est pas trouvée dans la base de données.
     */
    public function getBoxByToken(string $token): array {
        try{
            $box = Box::with('prestations')->where('token', $token)->firstOrFail();
            return $box->toArray();
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
            $boxes = Box::where('createur_id',"=", null )->get();
            return $boxes->toArray();
        } catch (\Exception $e) {
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
                throw new \Exception("Données de catégorie invalides.");
            }

            $box = new Box();
            $box->token = "";
            $box->libelle = $data['name'];
            $box->description = $data['description'];
            $box->montant = 0;
            $box->kdo = isset($data['kdo']) ? 1 : 0;
            $box->statut = 1;
            $box->message_kdo = $data['kdo_message'];
            $box->createur_id = $data['createur_id'];
            $box->save();

            //ajout des prestations de la box predefinie
            if($data['predefinie'] != "aucune"){
                $prestations = Box::findOrFail($data['predefinie'])->prestations;
                foreach ($prestations as $prestation) {
                    $box->prestations()->attach($prestation, ['quantite' => $prestation->pivot->quantite]);
                }
            }


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
            
            if ($box->statut != 1) {
                throw new BoxServiceNotFoundException("Impossible d'ajouter une prestation à un coffret non modifiable.");
            }

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
        } catch (\Exception $e) {
            throw new BoxServiceNotFoundException("Échec de l'ajout de la prestation au coffret.");
        }
    }
    
    public function removePrestationToBox(string $prestationId, string $boxId): void {
        try{
            if(is_null($prestationId) || is_null($boxId)){
                throw new BoxServiceNotFoundException("Échec de la suppression de la prestation au coffret.");
            }

            $box = Box::findOrFail($boxId);
            $prestation = Prestation::findOrFail($prestationId);
            
            // check si la prestation est déjà dans le coffret
            $existingPrestation = $box->prestations()->where('presta_id', $prestationId)->first();

            if ($existingPrestation) {
                // supprime la prestation du coffret
                $box->prestations()->detach($prestation);
            }

            // met à jour le montant du coffret
            $totalMontant = 0;
            foreach ($box->prestations as $prestation) {
                $totalMontant += $prestation->pivot->quantite * $prestation->tarif;
            }
            $box->montant = $totalMontant;

            $box->save();
        } catch (\Exception $e) {
            throw new BoxServiceNotFoundException("Échec de la suppression de la prestation au coffret.");
        }
    }
    
    public function updateQuantitePrestationToBox(string $prestationId, string $boxId, int $quantite): void {
        try{
            if(is_null($prestationId) || is_null($boxId)){
                throw new BoxServiceNotFoundException("Échec de la mise à jour de la quantité de la prestation au coffret.");
            }

            $box = Box::findOrFail($boxId);
            $prestation = Prestation::findOrFail($prestationId);
            
            // check si la prestation est déjà dans le coffret
            $existingPrestation = $box->prestations()->where('presta_id', $prestationId)->first();

            if ($existingPrestation) {
                if ($quantite <= 0) {
                    // supprime la prestation du coffret
                    $box->prestations()->detach($prestation);
                } else {
                    // met à jour la quantité de la prestation
                    $existingPrestation->pivot->quantite = $quantite;
                    $existingPrestation->pivot->save();
                }
            }

            // met à jour le montant du coffret
            $totalMontant = 0;
            foreach ($box->prestations as $prestation) {
                $totalMontant += $prestation->pivot->quantite * $prestation->tarif;
            }
            $box->montant = $totalMontant;

            $box->save();
        } catch (\Exception $e) {
            throw new BoxServiceNotFoundException("Échec de la mise à jour de la quantité de la prestation au coffret.");
        }
    }

    public function getBoxByUserId(string $userId): array {
        try{
            $box = Box::where('createur_id', $userId)->get();
            return $box->toArray();
        } catch (\Exception $e) {
            throw new BoxServiceNotFoundException("Échec de la récupération des boxs depuis la base de données.");
        }
    }

    public function validateBox(string $boxId): bool {
        try {
            $box = Box::findOrFail($boxId);
    
            // Vérifie que le coffret n'est pas déjà validé
            if ($box->statut == 2) {
                throw new BoxServiceNotFoundException("Le coffret est déjà validé.");
            }
    
            // Vérifie que le coffret contient au moins 2 prestations de 2 catégories différentes
            $categories = [];
            foreach ($box->prestations as $prestation) {
                $categories[] = $prestation->categorie;
            }
            if (count($box->prestations) < 2 || count(array_unique($categories)) < 2) {
                throw new BoxServiceNotFoundException("Le coffret doit contenir au moins 2 prestations de 2 catégories différentes pour être validé.");
            }
    
            // Marque le coffret comme validé
            $box->statut = 2;
            $box->save();
    
            return true;
        } catch (\Exception $e) {
            throw new BoxServiceNotFoundException($e->getMessage());
        }
    }

    public function payBox(string $boxId): bool {
        try {
            $box = Box::findOrFail($boxId);
    
            // Vérifie que le coffret est validé
            if ($box->statut != 2) {
                throw new BoxServiceNotFoundException("Le coffret doit être validé avant d'être payé.");
            }
    
            // Marque le coffret comme payé
            $box->statut = 3;
            $box->save();
    
            return true;
        } catch (\Exception $e) {
            throw new BoxServiceNotFoundException($e->getMessage());
        }
    }
}
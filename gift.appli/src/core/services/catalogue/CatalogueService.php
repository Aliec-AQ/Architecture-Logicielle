<?php
namespace gift\appli\core\services\catalogue;

use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;

use gift\appli\core\domain\entites\Categorie;
use gift\appli\core\domain\entites\Prestation;

/**
 * Service de catalogue pour gérer les catégories et les prestations.
 */
class CatalogueService implements CatalogueServiceInterface {

    /**
     * Récupère toutes les catégories.
     *
     * @return array Tableau contenant toutes les catégories.
     * @throws CatalogueServiceNotFoundException Si la récupération des catégories échoue.
     */
    public function getCategories(): array {
        try {
            $categories = Categorie::all();
            return $categories->toArray();
        } catch (\Exception $e) {
            throw new CatalogueServiceNotFoundException("Échec de la récupération des catégories depuis la base de données.");
        }
    }

    /**
     * Récupère une catégorie par son identifiant.
     *
     * @param int $id L'identifiant de la catégorie.
     * @return array Tableau contenant les informations de la catégorie.
     * @throws CatalogueServiceNotFoundException Si la récupération de la catégorie échoue.
     */
    public function getCategorieById(int $id): array {
        try {
            $categorie = Categorie::findOrFail($id);
            return $categorie->toArray();
        } catch (\Exception $e) {
            throw new CatalogueServiceNotFoundException("Échec de la récupération de la catégorie depuis la base de données.");
        }
    }

    /**
     * Récupère une prestation par son identifiant.
     *
     * @param string $id L'identifiant de la prestation.
     * @return array Tableau contenant les informations de la prestation.
     * @throws CatalogueServiceNotFoundException Si la récupération de la prestation échoue.
     */
    public function getPrestationById(string $id): array {
        try{
            $prestation = Prestation::findOrFail($id);
            return $prestation->toArray();
        } catch (\Exception $e) {
            throw new CatalogueServiceNotFoundException("Échec de la récupération de la prestation depuis la base de données.");
        }
    }

    /**
     * Récupère toutes les prestations d'une catégorie.
     *
     * @param int $categ_id L'identifiant de la catégorie.
     * @return array Tableau contenant toutes les prestations de la catégorie.
     * @throws CatalogueServiceNotFoundException Si la récupération des prestations échoue.
     */
    public function getPrestationsbyCategorie(int $categ_id): array {
        try {
            $prestations = Categorie::findOrFail($categ_id)->prestations;
            return $prestations->toArray();
        } catch (\Exception $e) {
            throw new CatalogueServiceNotFoundException("Échec de la récupération des prestations depuis la base de données.");
        }
    }

    /**
     * Récupère toutes les prestations.
     *
     * @return array Tableau contenant toutes les prestations.
     * @throws CatalogueServiceNotFoundException Si la récupération des prestations échoue.
     */
    public function getPrestations(): array {
        try {
            $prestations = Prestation::all();
            return $prestations->toArray();
        } catch (\Exception $e) {
            throw new CatalogueServiceNotFoundException("Échec de la récupération des prestations depuis la base de données.");
        }
    }

    /**
     * Récupère toutes les prestations triées selon un critère.
     *
     * @param string $sort Le critère de tri.
     * @return array Tableau contenant toutes les prestations triées.
     * @throws CatalogueServiceNotFoundException Si la récupération des prestations triées échoue.
     */
    public function getPrestationsSorted(string $sort): array {
        try {
            $orderBy = [
                'alphabet_asc' => ['column' => 'libelle', 'direction' => 'asc'],
                'alphabet_desc' => ['column' => 'libelle', 'direction' => 'desc'],
                'price_asc' => ['column' => 'tarif', 'direction' => 'asc'],
                'price_desc' => ['column' => 'tarif', 'direction' => 'desc']
            ];
            if (array_key_exists($sort, $orderBy)) {
                $prestations = Prestation::with('categorie')->orderBy($orderBy[$sort]['column'], $orderBy[$sort]['direction'])->get();
            } else {
                $prestations = Prestation::with('categorie')->get();
            }
            return $prestations->toArray();
        } catch (\Exception $e) {
            throw new CatalogueServiceNotFoundException("Échec de la récupération des prestations triées depuis la base de données.");
        }
    }

    /**
     * Crée une nouvelle catégorie.
     *
     * @param array $data Les données de la catégorie.
     * @return int L'identifiant de la catégorie créée.
     * @throws CatalogueServiceNotFoundException Si la création de la catégorie échoue.
     */
    public function createCategorie(array $data): int {
        try {
            $categorie = new Categorie($data);
            $categorie->save();
            return $categorie->id;
        } catch (\Exception $e) {
            throw new CatalogueServiceNotFoundException("Échec de la création de la catégorie.");
        }
    }

    /**
     * Met à jour une prestation.
     *
     * @param array $data Les données de la prestation à mettre à jour.
     * @throws CatalogueServiceNotFoundException Si la modification de la prestation échoue.
     */
    public function updatePrestation(array $data): void {
        try {
            $prestation = Prestation::findOrFail($data['id']);
            $prestation->update($data);
        } catch (\Exception $e) {
            throw new CatalogueServiceNotFoundException("Échec de la modification de la prestation.");
        }
    }

    /**
     * Définit ou modifie la catégorie d'une prestation.
     *
     * @param int $prestationId L'identifiant de la prestation.
     * @param int $categorieId L'identifiant de la catégorie.
     * @throws CatalogueServiceNotFoundException Si la définition ou la modification de la catégorie de la prestation échoue.
     */
    public function setPrestationCategorie(int $prestationId, int $categorieId): void {
        try {
            $prestation = Prestation::findOrFail($prestationId);
            $prestation->categorie_id = $categorieId;
            $prestation->save();
        } catch (\Exception $e) {
            throw new CatalogueServiceNotFoundException("Échec de la définition ou de la modification de la catégorie de la prestation.");
        }
    }
}
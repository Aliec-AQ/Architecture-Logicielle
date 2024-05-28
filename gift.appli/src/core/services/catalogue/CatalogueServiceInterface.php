<?php 

namespace gift\appli\core\services\catalogue;

/**
 * Interface CatalogueServiceInterface
 * 
 * Cette interface définit les méthodes pour accéder aux fonctionnalités du catalogue.
 */
interface CatalogueServiceInterface {
    /**
     * Récupère toutes les catégories du catalogue.
     *
     * @return array Un tableau contenant toutes les catégories.
     */
    public function getCategories(): array;

    /**
     * Récupère une catégorie du catalogue par son identifiant.
     *
     * @param int $id L'identifiant de la catégorie.
     * @return array Les informations de la catégorie.
     */
    public function getCategorieById(int $id): array;

    /**
     * Récupère une prestation du catalogue par son identifiant.
     *
     * @param string $id L'identifiant de la prestation.
     * @return array Les informations de la prestation.
     */
    public function getPrestationById(string $id): array;

    /**
     * Récupère toutes les prestations d'une catégorie donnée.
     *
     * @param int $categ_id L'identifiant de la catégorie.
     * @return array Un tableau contenant toutes les prestations de la catégorie.
     */
    public function getPrestationsbyCategorie(int $categ_id): array;

    /**
     * Récupère toutes les prestations du catalogue.
     *
     * @return array Un tableau contenant toutes les prestations.
     */
    public function getPrestations(): array;

    /**
     * Récupère toutes les prestations du catalogue triées selon un critère donné.
     *
     * @param string $sort Le critère de tri.
     * @return array Un tableau contenant toutes les prestations triées.
     */
    public function getPrestationsSorted(string $sort): array;

    /**
     * Crée une nouvelle catégorie.
     *
     * @param array $data Les données de la catégorie.
     * @return int L'identifiant de la catégorie créée.
     */
    public function createCategorie(array $data): int;

    /**
     * Met à jour les informations d'une prestation du catalogue.
     *
     * @param array $data Les nouvelles informations de la prestation.
     * @return void
     */
    public function updatePrestation(array $data): void;

    /**
     * Associe une prestation à une catégorie donnée.
     *
     * @param int $prestationId L'identifiant de la prestation.
     * @param int $categorieId L'identifiant de la catégorie.
     * @return void
     */
    public function setPrestationCategorie(int $prestationId, int $categorieId): void;
}
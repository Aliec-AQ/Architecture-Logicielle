<?php
namespace gift\api\core\services\box;

/**
 * Interface BoxServiceInterface
 * 
 * Cette interface définit les méthodes pour gérer les boîtes cadeaux.
 */
interface BoxServiceInterface {
    /**
     * Récupère une boîte cadeau par son identifiant.
     * 
     * @param string $id L'identifiant de la boîte cadeau.
     * @return array Les informations de la boîte cadeau.
     */
    public function getBoxById(string $id): array;

    /**
     * Récupère toutes les boîtes cadeaux.
     * 
     * @return array Les informations de toutes les boîtes cadeaux.
     */
    public function getBoxes(): array;

    /**
     * Récupère les boîtes cadeaux prédéfinies.
     * 
     * @return array Les informations des boîtes cadeaux prédéfinies.
     */
    public function getPredefinedBoxes(): array;
}
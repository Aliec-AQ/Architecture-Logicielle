<?php
namespace gift\appli\core\services\autorisation;


/*
* Interface AutorisationServiceInterface
*
* Cette interface définit les méthodes pour accéder aux fonctionnalités d'autorisation.
*/
interface AutorisationServiceInterface {

    public function isGranted(?string $id, ?int $action, ?int $box_id = null): bool;
}
<?php
namespace gift\appli\core\services\autorisation;

use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\domain\entites\User;


class AutorisationService implements AutorisationServiceInterface{
    private const ROLE_USER = 1;
    private const ROLE_ADMIN = 100;

    const MODIF_BOX = 1;
    const CREATE_BOX = 2;
    const MODIF_CATALOGUE = 3;

    public function isGranted(?string $id, ?int $action, ?string $box_id = null): bool {     
        if(is_null($id) ||is_null($action)){
            return false;
        }
        
        switch ($action) {
            case self::MODIF_BOX:
                return $this->isOwner($id, $box_id) || $this->isAdmin($id);
            case self::CREATE_BOX:
                return $this->isRegistered($id) || $this->isAdmin($id);
            case self::MODIF_CATALOGUE:
                return $this->isAdmin($id);
            default:
                return false;
        }
    }

    private function isAdmin (string $id): bool {
        $user = User::where('id', $id)->first();
        if ($user && $user->role == self::ROLE_ADMIN) {
            return true;
        }
        return false;
    }

    private function isOwner(string $id, string $box_id): bool {
        if(is_null($box_id)){
            return false;
        }

        $user = User::where('id', $id)->first();
        if ($user && $user->boxes->contains($box_id)) {
            return true;
        }
        return false;
    }

    private function isRegistered(string $id): bool {
        if (User::where('id', $id)->exists()) {
            return true;
        }
        return false;
    }
}
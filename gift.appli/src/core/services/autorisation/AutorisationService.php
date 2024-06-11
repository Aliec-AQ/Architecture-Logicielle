<?php
namespace gift\appli\core\services\autorisation;

use gift\appli\core\services\autorisation\AutorisationServiceInterface;
use gift\appli\core\domain\entites\User;
use gift\appli\core\domain\entites\Box;


class AutorisationService implements AutorisationServiceInterface{

    const MODIF_BOX = 1;
    const CREATE_BOX = 2;
    const MODIF_CATALOGUE = 3;

    public function isGranted(?string $id, ?int $action, ?string $box_id = null): bool {     
        if(is_null($id) ||is_null($action)){
            return false;
        }

        switch ($action) {
            case self::MODIF_BOX:
                return $this->isModifiable($box_id) && ( $this->isOwner($id, $box_id) || $this->isAdmin($id) );
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
        if ($user && $user->role == User::ROLE_ADMIN) {
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

    private function isModifiable(string $box_id): bool {
        if(is_null($box_id)){
            return false;
        }

        $box = Box::where('id', $box_id)->first();
        if ($box && $box->statut == Box::EN_COURS) {
            return true;
        }
        return false;
    }
}
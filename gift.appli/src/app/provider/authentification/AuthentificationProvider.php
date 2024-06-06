<?php 
namespace gift\appli\app\provider\authentification;

use gift\appli\app\provider\authentification\AuthentificationProviderInterface;
use gift\appli\core\services\authentification\AuthentificationServiceInterface;
use gift\appli\core\services\authentification\AuthentificationService;
use gift\appli\core\services\authentification\AuthentificationServiceException;

class AuthentificationProvider implements AuthentificationProviderInterface{
    private AuthentificationServiceInterface $authentificationService;

    public function __construct(){
        $this->authentificationService = new AuthentificationService();
    }

    public function register(string $email, string $password) {
        try {
            $user = $this->authentificationService->register($email, $password);
            $_SESSION['gift_box_user'] = $user;
        } catch (AuthentificationServiceException $e) {
            return $e->getMessage();
        }
    }

    public function signIn(string $email, string $password) {
        try {
            $user = $this->authentificationService->checkUser($email, $password);
            $_SESSION['gift_box_user'] = $user;
        } catch (AuthentificationServiceException $e) {
            return $e->getMessage();
        }
    }

    public function signOut() {
        unset($_SESSION['gift_box_user']);
    }

    public function isSignedIn(): bool {
        return isset($_SESSION['gift_box_user']);
    }

    public function getSignedInUser(): array {
        if($this->isSignedIn()){
            return $_SESSION['gift_box_user'];
        }
        return ['id' => null];
    }
}
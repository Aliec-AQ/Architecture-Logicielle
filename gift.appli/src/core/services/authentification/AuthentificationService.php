<?php
namespace gift\appli\core\services\authentification;

use gift\appli\core\services\authentification\AuthentificationServiceInterface;
use gift\appli\core\domain\entites\User;
/*
* Service d'authentification pour gérer les utilisateurs.
*/
class AuthentificationService implements AuthentificationServiceInterface{
    private const ROLE_USER = 1;
    private const ROLE_ADMIN = 100; 

    public function register(string $email, string $password): array {        
        // Vérifie si l'email est déjà utilisé
        if (User::where('user_id', $email)->exists()) {
            throw new AuthentificationServiceException('Cet email est déjà utilisé');
        }

        // Vérifie si le mot de passe est valide (au moins 10 caractères, une minuscule, une majuscule, un chiffre et un caractère spécial)
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/', $password)) {
            throw new AuthentificationServiceException('Le mot de passe doit contenir au moins 10 caractères, une minuscule, une majuscule, un chiffre et un caractère spécial');
        }
        
        $user = new User();
        $user->role = self::ROLE_USER;
        $user->user_id = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        
        try{
            if($user->save()){
                return $user->toArray(['id', 'user_id']);
            }else{
                throw new AuthentificationServiceException('Erreur lors de l\'enregistrement de l\'utilisateur');
            }
        }catch(\Exception $e){
            throw new AuthentificationServiceException('Erreur lors de l\'enregistrement de l\'utilisateur');
        }
    }

    public function checkUser(string $email, string $password): array {
        $user = User::where('user_id', $email)->first();
        if ($user && password_verify($password, $user->password)) {
            return $user->toArray(['id', 'user_id']);
        }
        throw new AuthentificationServiceException('Email ou mot de passe incorrect');
    }
}
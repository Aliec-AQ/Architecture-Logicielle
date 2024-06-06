<?php
namespace gift\appli\core\services\authentification;


/*
* Interface AuthentificationServiceInterface
*
* Cette interface définit les méthodes pour accéder aux fonctionnalités d'authentification.
*/
interface AuthentificationServiceInterface {

    public function checkUser(string $email, string $password): array;

    public function register(string $email, string $password): array;
}
<?php
namespace gift\appli\app\provider\authentification;

interface AuthentificationProviderInterface {
    public function register(string $email, string $password);

    public function signIn(string $email, string $password);

    public function signOut();

    public function isSignedIn(): bool;

    public function getSignedInUser(): array;
}
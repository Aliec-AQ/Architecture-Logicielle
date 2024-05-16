<?php
require_once __DIR__ . '/../../vendor/autoload.php';
gift\appli\bd\BdManager::connect();

/*
6. Créer une box et lui ajouter 3 prestations. L’identifiant de la box est un UUID.
Consulter la documentation Eloquent pour la génération de cet identifiant.
*/

// Create a box
$box = new gift\appli\models\Box();
$box->libelle = "Box 1";
$box->kdo = 0;
$box->statut = 0;
$box->token = 'token';
$box->save();

// Add 3 random prestations to the box
$prestations = gift\appli\models\Prestation::all()->random(3);
foreach ($prestations as $prestation) {
    $box->prestations()->attach($prestation, ['quantite' => 1]);
}
$box->save();
<?php
require_once __DIR__ . '/../../vendor/autoload.php';
gift\appli\bd\BdManager::connect();

/*
1. lister les prestations ; pour chaque prestation, afficher le libellé, la description, le
tarif et l'unité.
*/
$prestations = gift\appli\models\Prestation::all();

foreach ($prestations as $prestation) {
    echo "Libellé: " . $prestation->libelle . "\n";
    echo "Description: " . $prestation->description . "\n";
    echo "Tarif: " . $prestation->tarif . "\n";
    echo "Unité: " . $prestation->unite . "\n";
}

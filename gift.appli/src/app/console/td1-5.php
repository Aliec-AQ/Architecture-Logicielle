<?php
require_once __DIR__ . '/../../vendor/autoload.php';
gift\appli\app\utils\Eloquent::init(__DIR__ . '/../../conf/gift.db.conf.ini.dist');

/*
5. idem, en affichant en plus les prestations prévues dans la box (libellé, tarif, unité,
quantité).
*/

$box = gift\appli\models\Box::find('360bb4cc-e092-3f00-9eae-774053730cb2');
if ($box) {
    echo "Box ID: " . $box->id . "\n";
    echo "Libellé: " . $box->libelle . "\n";
    echo "Description: " . $box->description . "\n";
    echo "Montant: " . $box->montant . "\n";
    echo "\n";

    echo "Prestations prévues dans la box:\n";
    foreach ($box->prestations as $prestation) {
        echo "Prestation ID: " . $prestation->id . "\n";
        echo "Libellé: " . $prestation->libelle . "\n";
        echo "Tarif: " . $prestation->tarif . "\n";
        echo "Unité: " . $prestation->unite . "\n";
        echo "Quantité: " . $prestation->pivot->quantite . "\n";
        echo "\n";
    }
} else {
    echo "Box not found.";
}
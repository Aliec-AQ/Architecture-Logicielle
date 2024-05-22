<?php
require_once __DIR__ . '/../../vendor/autoload.php';
gift\appli\app\utils\Eloquent::init(__DIR__ . '/../../conf/gift.db.conf.ini.dist');

/*
4. afficher la box d'ID 360bb4cc-e092-3f00-9eae-774053730cb2 : libellé, description,
montant.
*/

$box = gift\appli\models\Box::find('360bb4cc-e092-3f00-9eae-774053730cb2');
if ($box) {
    echo "Libellé: " . $box->libelle . "\n";
    echo "Description: " . $box->description . "\n";
    echo "Montant: " . $box->montant . "\n";
} else {
    echo "Box not found.";
}
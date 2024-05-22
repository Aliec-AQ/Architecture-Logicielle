<?php
require_once __DIR__ . '/../../vendor/autoload.php';
gift\appli\app\utils\Eloquent::init(__DIR__ . '/../../conf/gift.db.conf.ini.dist');

/*
2. idem, mais en affichant de plus la catégorie de la prestation. On utilisera un
chargement lié (eager loading).
*/
$prestations = gift\appli\models\Prestation::with('categorie')->get();

foreach ($prestations as $prestation) {
    echo "Libellé: " . $prestation->libelle . "\n";
    echo "Description: " . $prestation->description . "\n";
    echo "Tarif: " . $prestation->tarif . "\n";
    echo "Unité: " . $prestation->unite . "\n";
    echo "Catégorie: " . $prestation->categorie->libelle . "\n";
}
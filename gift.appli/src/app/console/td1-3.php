<?php
require_once __DIR__ . '/../../vendor/autoload.php';
gift\appli\bd\BdManager::connect();

/*
3. afficher la catégorie 3 (libellé) et la liste des prestations (libellé, tarif, unité) de cette
catégorie. 
*/

$category = 3;
$categorieLibelle = gift\appli\models\Categorie::where('id', $category)->value('libelle');
$Prestation = gift\appli\models\Prestation::where('cat_id', $category)->get();

echo "Categorie: " . $categorieLibelle . "\n";
echo "Prestations:\n";
foreach ($Prestation as $presta) {
    echo "Label: " . $presta->libelle . ", Tariff: " . $presta->tarif . ", Unit: " . $presta->unite . "\n";
}
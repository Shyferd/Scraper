<?php
date_default_timezone_set('Europe/Paris');
set_time_limit(0);
include "../Libs/simple_html_dom.php";
include "fonctions.php";
include "cnx.php";
$fichier = file("../links.txt");
$total = count($fichier);
$count=0;
$number=0;
do {
    for ($categorie = 0; $categorie < $total; $categorie++) {
        if ($count > 1) {
            sleep(300);
        }
        $table[$categorie] = findSousCateg($fichier[$categorie]);
        $avancement = $categorie;
        echo "Avancement catégorie : " . ($avancement + 1) . "/22";
        foreach ($table[$categorie] as $souscateg) {
            foreach ($souscateg as $objet) {
                $queryEtat = $cnx->prepare('INSERT INTO `table2` VALUES("' . $objet['CategorieMere'] . '", "' . $objet['CategorieFille'] . '", "' . $objet['Rang'] . '", "' . $objet['Marque'] . '", "' . $objet['Expediteur'] . '", "' . $objet['ASIN'] . '", "' . tofloat($objet['etoile']) . '", "' . intval($objet['note']) . '", "' . $objet['date'] . '");');
                try {
                    $queryEtat->execute();
                    error_log(date("d-m-Y h:i:s") . ' Catégorie : ' . $objet['CategorieMere'] . " = OK\n\n", 3, '../Logs/Avancement.log');
                } catch (Exception $e) {
                    error_log(date("d-m-Y h:i:s") . ' Catégorie : ' . $objet['CategorieMere'] . " = KO\n\n", 3, '../Logs/Avancement.log');
                    error_log(date("d-m-Y h:i:s") . ' Error : ' . $e->getMessage() . "\n\n", 3, '../Logs/Error.log');
                }
            }
        }
        $count++;
        $number++;
        var_dump($number);
    }
} while ($number<20);
echo "FINISH !";




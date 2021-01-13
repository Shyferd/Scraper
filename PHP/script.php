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
error_log(date("d-m-Y h:i:s") . ' Lancement du script : '. " \n\n", 3, '../Logs/Avancement.log');

do {
    for ($categorie = 0; $categorie < $total; $categorie++) {
        if ($count > 1) {
            sleep(300);
        }
        error_log(date("d-m-Y h:i:s") . ' Scrapping catégorie : '.($categorie+1).'/20'." en cours.\n\n", 3, '../Logs/Avancement.log');
        $table[$categorie] = findSousCateg($fichier[$categorie]);
        foreach ($table[$categorie] as $souscateg) {
            foreach ($souscateg as $objet) {
                $queryEtat = $cnx->prepare('INSERT INTO `table2` VALUES("' . $objet['CategorieMere'] . '", "' . $objet['CategorieFille'] . '", "' . $objet['Rang'] . '", "' . $objet['Marque'] . '", "' . $objet['Expediteur'] . '", "' . $objet['ASIN'] . '", "' . tofloat($objet['etoile']) . '", "' . intval($objet['note']) . '", "' . $objet['date'] . '");');
                try {
                    $queryEtat->execute();
                } catch (Exception $e) {
                    error_log(date("d-m-Y h:i:s") . ' Catégorie : ' . $objet['CategorieMere'] . " = KO\n\n", 3, '../Logs/Avancement.log');
                    error_log(date("d-m-Y h:i:s") . ' Error : ' . $e->getMessage() . "\n\n", 3, '../Logs/Error.log');
                }
            }
        }
        $count++;
        $number++;
        error_log(date("d-m-Y h:i:s") . ' Catégorie : ' . $objet['CategorieMere'] . " = DONE\n\n", 3, '../Logs/Avancement.log');
    }
} while ($number<20);
error_log(date("d-m-Y h:i:s") . ' FIN du script : '. " \n\n", 3, '../Logs/Avancement.log');




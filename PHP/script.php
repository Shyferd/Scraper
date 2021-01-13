<?php
date_default_timezone_set('Europe/Paris');
//set_time_limit(0);
include "../Libs/simple_html_dom.php";
include "fonctions.php";
include "cnx.php";
$fichier = file("../links.txt");
$total = count($fichier);
$count=0;
for($categorie = 0;$categorie < $total; $categorie++) {
    if ($count>1){sleep(300);}
    $table[$categorie]=findSousCateg($fichier[$categorie]);
    $avancement = $categorie;
    echo "Avancement catégorie : ".($avancement+1)."/22";
    foreach ($table[$categorie] as $souscateg){
        foreach ($souscateg as $objet){
            $queryEtat=$cnx->prepare('INSERT INTO `table2` VALUES("'.$objet['CategorieMere'].'", "'.$objet['CategorieFille'].'", "'.$objet['Rang'].'", "'.$objet['Marque'].'", "'.$objet['Expediteur'].'", "'.$objet['ASIN'].'", "'.tofloat($objet['etoile']).'", "'.intval($objet['note']).'", "'.$objet['date'].'");');
           try {
                $queryEtat->execute();
            }catch (Exception $e) {
               error_log(date("d-m-Y h:i:s").' Error : '.$e->getMessage()."\n\n", 3, '../Logs/mylog.log');            }
        }
    }
    $count++;
}

echo "FINISH !";




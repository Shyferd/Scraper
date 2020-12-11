<?php
date_default_timezone_set('Europe/Paris');
include "../Libs/simple_html_dom.php";
include "fonctions.php";
include "cnx.php";

$fichier = file("../links.txt");
$total = count($fichier);
for($categorie = 0; $categorie < 1; $categorie++) {
    $table[$categorie]=findSousCateg($fichier[$categorie]);
    //var_dump($table[$categorie]);break;
    foreach ($table[$categorie] as $souscateg){
        foreach ($souscateg as $objet){
            var_dump($objet);
            $queryEtat=$cnx->prepare('INSERT INTO `table1` VALUES("'.$objet['CategorieMere'].'", "'.$objet['CategorieFille'].'", "'.$objet['Rang'].'", "'.$objet['Marque'].'", "'.$objet['Expediteur'].'", "'.$objet['ASIN'].'", "'.$objet['etoile'].'", "'.$objet['note'].'", "'.$objet['date'].'");');
            $queryEtat->execute();
        }
    }
    /*for($objet=1;$objet< (count($table[$categorie])+1);$objet++){
        $queryEtat=$cnx->prepare('INSERT INTO `table1` VALUES("'.$table[$categorie][$objet]['CategorieMere'].'", "'.$table[$categorie][$objet]['CategorieFille'].'", "'.$table[$categorie][$objet]['Rang'].'", "'.$table[$categorie][$objet]['Marque'].'", "'.$table[$categorie][$objet]['Expediteur'].'", "'.$table[$categorie][$objet]['ASIN'].'", "'.$table[$categorie][$objet]['etoile'].'", "'.$table[$categorie][$objet]['note'].'", "'.$table[$categorie][$objet]['date'].'");');
        $queryEtat->execute();
    }*/
}

echo "FINISH !";




<?php
date_default_timezone_set('Europe/Paris');
include "../Libs/simple_html_dom.php";
include "fonctions.php";
include "cnx.php";

$fichier = file("../links.txt");
$total = count($fichier);
for($categorie = 0; $categorie < 2; $categorie++) {
    $table[$categorie]=findObjects($fichier[$categorie]);

    for($objet=1;$objet< (count($table[$categorie])+1);$objet++){
        $queryEtat=$cnx->prepare('INSERT INTO `table1` VALUES("'.$table[$categorie][$objet]['Categorie'].'", "'.$table[$categorie][$objet]['Rang'].'", "'.$table[$categorie][$objet]['Marque'].'", "'.$table[$categorie][$objet]['Expediteur'].'", "'.$table[$categorie][$objet]['ASIN'].'", "'.$table[$categorie][$objet]['etoile'].'", "'.$table[$categorie][$objet]['note'].'", "'.$table[$categorie][$objet]['date'].'");');
        $queryEtat->execute();
    }
}

echo "FINISH !";




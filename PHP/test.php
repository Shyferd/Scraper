<?php

date_default_timezone_set('Europe/Paris');
//set_time_limit(0);
include "../Libs/simple_html_dom.php";
include "fonctions.php";
include "cnx.php";
//$fichier = file("../links.txt");
//$total = count($fichier);
//$count = 0;
//$objet['CategorieMere'] = 'test1';
//$objet['CategorieFille'] = 'test2';
//$objet['Rang'] = '#4';
//$objet['Marque'] = 'toto';
//$objet['Expediteur'] = 'maman';
//$objet['ASIN'] = "azerty";
//$objet['etoile'] = '4,5';
//$objet['note'] = '4421';
//$objet['date'] = date("Y-m-d");
$tables = "toto";

$queryTable=$cnx->prepare("CREATE TABLE ".$tables." (
  'CategorieMere' text NOT NULL,
  'CategorieFille' text NOT NULL,
  'Rang' text NOT NULL,
  'Marque' text,
  'Expediteur' text,
  'ASIN' text NOT NULL,
  'etoile' float DEFAULT NULL,
  'note' int(11) DEFAULT NULL,
  'date' date NOT NULL
)");
try {
    $queryTable->execute();
}catch (Exception $e){
    error_log(date("d-m-Y h:i:s").' Error : '.$e->getMessage()."\n\n", 3, '../Logs/mylog.log');
}


//$queryEtat=$cnx->prepare('INSERT INTO `table2` VALUES("'.$objet['CategorieMere'].'", "'.$objet['CategorieFille'].'", "'.$objet['Rang'].'", "'.$objet['Marque'].'", "'.$objet['Expediteur'].'", "'.$objet['ASIN'].'", "'.tofloat($objet['etoile']).'", "'.intval($objet['note']).'", "'.$objet['date'].'");');
//$queryEtat->execute();
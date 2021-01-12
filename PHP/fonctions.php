<?php
function after ($a, $inthat)
{
    if (!is_bool(strpos($inthat, $a)))
        return substr($inthat, strpos($inthat,$a)+strlen($a));
};

function before ($a, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $a));
};

function between ($a, $that, $inthat)
{
    return before ($that, after($a, $inthat));
};

function findSousCateg($htmlink){
    $i=1;
    $html=file_get_html($htmlink);
    sleep(1.5);
    $categorie=after('en ',$html->find('h1')[0]->plaintext);
    foreach($html->find('ul[id=zg_browseRoot]') as $liste)
    {
        foreach($liste->find('a[href]') as $sousCateg)
        {
            $sousCategName[$sousCateg->plaintext]=($sousCateg->href);
            if (isset($sousCategName['Tout département'])){
                unset($sousCategName['Tout département']);
            }else {
                $objects[$i]= findObjects($sousCategName[$sousCateg->plaintext], $categorie);
                $i++;
                //var_dump($objects);break;
            }
        }
    }
    return $objects;
};

function findObjects($htmlink, $categorie){
    $i=1;
    $html=file_get_html($htmlink);
    sleep(1.5);
    foreach($html->find('ol') as $ul)
    {
        foreach($ul->find('li') as $li)
        {
            try {
                $ojects[$i]['CategorieMere']=$categorie;
                $ojects[$i]['CategorieFille']=after('en ',$html->find('h1')[0]->plaintext);
                $ojects[$i]['Rang']=$li->find('span[class=zg-badge-text]')[0]->plaintext;
                $url = $li->find('a[class=a-link-normal]')[0]->href;
                $html2=file_get_contents("https://www.amazon.fr".$url);
                sleep(1.5);
                $ojects[$i]['Marque']=between('Marque&nbsp;: ','</a>', $html2);
                $ojects[$i]['Expediteur']=between("sellerProfileTriggerId'>",'</a>', $html2);
                if(stristr($ojects[$i]['Expediteur'], '"')) {
                    $ojects[$i]['Expediteur'] = str_replace('"', "", $ojects[$i]['Expediteur']);
                }
                $asin=between('dp/','/ref',$url);
                $ojects[$i]['ASIN']=$asin;
                $ojects[$i]['etoile']=before(' ',$li->find('span[class=a-icon-alt]')[0]->plaintext);
                $ojects[$i]['note']=$li->find('a[class=a-size-small a-link-normal]')[0]->plaintext;
                $ojects[$i]['date']=date("Y-m-d");
                $i++;
                if ($i == 11) break;
            }catch (Exception $e) {
                echo 'Exception reçue : ',  $e->getMessage(), "\n";
                mylog($e->getMessage());
            }
        }

    }
    return $ojects;
};

function tofloat($num) {
    $dotPos = strrpos($num, '.');
    $commaPos = strrpos($num, ',');
    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

    if (!$sep) {
        return floatval(preg_replace("/[^0-9]/", "", $num));
    }

    return floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
    );
};

function mylog($desc) {
    $ERROR_FILE = file('../mon_fichier.log');
    /* ligne à écrire */
    $ligne = date('Y-m-d H:i:s')."\t".$_SERVER['PHP_SELF']."\t"."\t$desc";

    /* ouverture du fichier de log, le mode "a+" permet d'écrire à la fin */
    if($fp = fopen($ERROR_FILE, "a+")) {
        /* écriture de la ligne à concurrence de 1024 caractères */
        fwrite($fp, $ligne, 1024);
        /* fermeture du fichier */
        fclose($fp);
    }
}
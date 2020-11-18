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
function finfObjects($htmlink){
    $i=1;
    $html=file_get_html($htmlink);
    foreach($html->find('ol') as $ul)
    {
        foreach($ul->find('li') as $li)
        {
            $ojects[$i]['Categorie']=after('en ',$html->find('h1')[0]->plaintext);
            $ojects[$i]['Rang']=$li->find('span[class=zg-badge-text]')[0]->plaintext;
            $url = $li->find('a[class=a-link-normal]')[0]->href;
            $asin=between('dp/','/ref',$url);
            $ojects[$i]['ASIN']=$asin;
            $ojects[$i]['etoile']=before(' ',$li->find('span[class=a-icon-alt]')[0]->plaintext);
            $ojects[$i]['note']=$li->find('a[class=a-size-small a-link-normal]')[0]->plaintext;
            $ojects[$i]['date']=date("d-m-Y");
            $i++;
            if ($i == 11) break;
        }

    }
    return $ojects;
};

function marqueExpediteur($htmlink){
    $html=file_get_html($htmlink);
    //echo var_dump($html);
            $ojects['marque']=$html->find('html')[0];//[0]->plaintext;
            //$ojects['Expediteur']=$html->find('a[id=SSOFpopoverLink]');//[0]->plaintext;


    return $ojects;
};
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

function findObjects($htmlink){
    $i=1;
    $html=file_get_html($htmlink);
    foreach($html->find('ol') as $ul)
    {
        foreach($ul->find('li') as $li)
        {
            $ojects[$i]['Categorie']=after('en ',$html->find('h1')[0]->plaintext);
            $ojects[$i]['Rang']=$li->find('span[class=zg-badge-text]')[0]->plaintext;
            $url = $li->find('a[class=a-link-normal]')[0]->href;
            $html2=file_get_contents("https://www.amazon.fr".$url);
            $ojects[$i]['Marque']=between('Marque&nbsp;: ','</a>', $html2);
            $ojects[$i]['Expediteur']=between("sellerProfileTriggerId'>",'</a>', $html2);
            $asin=between('dp/','/ref',$url);
            $ojects[$i]['ASIN']=$asin;
            $ojects[$i]['etoile']=before(' ',$li->find('span[class=a-icon-alt]')[0]->plaintext);
            $ojects[$i]['note']=$li->find('a[class=a-size-small a-link-normal]')[0]->plaintext;
            $ojects[$i]['date']=date("Y-m-d");
            $i++;
            if ($i == 11) break;
        }

    }
    return $ojects;
};
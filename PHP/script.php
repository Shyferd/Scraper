<?php
include "../Libs/simple_html_dom.php";
$url = $_POST['url'];
$field = $_POST['field'];
$html = file_get_html($url);
$i=0;
    foreach($html->find('ol') as $ul)
    {
        foreach($ul->find('li') as $li)
        {
            $ojects[]=$li->plaintext;
            $i++;
            if ($i == 10) break;
        }
    }


var_dump($ojects);

<?php
include "SQLI.php";
//storing the result of the executed query
$result = mysqli_query($mysqli, "SELECT * FROM table1");
while($info=mysqli_fetch_array($result)) {
    echo $info[ 'Categorie' ].',';
}

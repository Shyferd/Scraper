<?php
@ini_set('display_errors', 'on');
session_start();
$dsn='mysql:dbname=mabase;host=localhost';
$login='scraper';
$motDePasse='password';
try{
    $cnx = new PDO($dsn, $login, $motDePasse,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

}
catch (PDOException $e){
    die('Erreur : ' . $e->getMessage());
}

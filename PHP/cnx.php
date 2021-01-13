<?php
@ini_set('display_errors', 'on');
session_start();
$dsn='mysql:dbname=mabase;host=127.0.0.1';
$login='root';
$motDePasse='root';
try{
    $cnx = new PDO($dsn, $login, $motDePasse,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

}
catch (PDOException $e){
    die('Erreur : ' . $e->getMessage());
}

<?php
/* Open connection to "zing_db" MySQL database. */
$mysqli = new mysqli("localhost", "scraper", "password", "mabase");

/* Check the connection. */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>

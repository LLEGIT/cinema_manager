<?php
//On donne les paramètres de la DB//
$db = mysqli_connect("localhost","root","mysqlisagreattool","cinema_db");

//Gestion d'erreur//
if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>


<?php
//On donne les paramètres de la DB//
$db = mysqli_connect("localhost","root","root","cinema");

//Gestion d'erreur//
if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>


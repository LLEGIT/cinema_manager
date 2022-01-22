<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY_CINEMA_CLIENTS</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php 
    //Pour bien se connecter à la base de donnée//
    include "../CONNECTION/dbConnection.php";
    $personId = $_GET['viewid'];
    $records = mysqli_query($db, "SELECT * FROM fiche_personne WHERE id_perso = '$personId'");
    $data = mysqli_fetch_array($records);
    ?>
    <h1>CONFIRMATION</h1>
    <form method='post' action='removeClient.php?viewid=<?php echo $personId;?>'>
        <h2>Êtes-vous sûr de vouloir supprimer les données de M./Mme <?php echo $data['prenom'] . " " . $data['nom']; ?> ?</h2>
        <input name='remove' type="submit" value='⚠️ SUPPRIMER ⚠️'>
    </form>
    <?php
    if (isset($_POST['remove'])) {
        $removeRequest = mysqli_query($db, "DELETE FROM fiche_personne WHERE id_perso='$personId'");
        usleep(100000);
        echo "Suppression effectué !";
    }?>
    <br>
    <br>
    <a class="navLinks" href='indexClients.php'>Retour à la liste des clients</a>
    <?php mysqli_close($db); //On ferme la connexion//?>
</body>

</html>
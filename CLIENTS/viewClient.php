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
    <h1>FICHE PERSONNE</h1>
    <?php
    //Pour bien se connecter à la base de donnée//
    include "../CONNECTION/dbConnection.php";
    $personId = $_GET['viewid'];
    $records = mysqli_query($db, "SELECT * FROM fiche_personne WHERE id_perso = '$personId'");
    while ($data = mysqli_fetch_array($records)) {
    ?>
        <table border="1">
            <tr>
                <td>Prénom</td>
                <td><?php echo $data['prenom']; ?></td>
            </tr>
            <tr>
                <td>Nom</td>
                <td><?php echo $data['nom']; ?></td>
            </tr>
            <tr>
                <td>E-mail</td>
                <td><?php echo $data['email']; ?></td>
            </tr>
            <tr>
                <td>Date de naissance</td>
                <td><?php echo $data['date_naissance']; ?></td>
            </tr>
            <tr>
                <td>Ville</td>
                <td><?php echo $data['ville']; ?></td>
            </tr>
            <tr>
                <td>Code Postal</td>
                <td><?php echo $data['cpostal']; ?></td>
            </tr>
        </table>
        <br>
        <a class="navLinks" href='editClient.php?viewid=<?php echo $personId?>'>Modifier</a>
        <br>
        <br>
        <a class="navLinks" href='indexClients.php'>Retour</a>
    <?php
    }
    ?>
    </table>
    <?php mysqli_close($db); //On ferme la connexion//?>

</body>

</html>
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
    $id_perso = $_GET['viewid'];
    //On récupère nom & prénom de la personne grâce à cette requête SQL//
    $records = mysqli_query($db, "SELECT prenom, nom FROM fiche_personne WHERE id_perso = '$id_perso'");
    $data = mysqli_fetch_array($records);
    ?>
    <h1>CONFIRMATION D'AJOUT DU MEMBRE</h1>
    <form method='post' action='clientToMember.php?viewid=<?php echo $id_perso;?>'>
        <h2>Êtes-vous sûr de vouloir ajouter M./Mme <?php echo $data['prenom'] . " " . $data['nom']; ?> en tant que membre du cinéma?</h2>
        <label for="subscriptions">
            Abonnement<br>
            <input type="radio" id="vip" name="subscriptions" value="1" checked>
            <label for="vip">VIP</label>

            <input type="radio" id="gold" name="subscriptions" value="2">
            <label for="gold">GOLD</label>

            <input type="radio" id="classic" name="subscriptions" value="3">
            <label for="classic">Classic</label>

            <input type="radio" id="pass_day" name="subscriptions" value="4">
            <label for="pass_day">Pass Day</label>
        </label><br><br>
        <input name='add' type="submit" value='AJOUTER'>
    </form>
    <?php
    //Si le bouton AJOUTER est pressé, on envoie le form//
    if (isset($_POST['add'])) {
        $subscriptions = $_POST['subscriptions'];
        //On fait une requête SQL afin de créer un id_fiche_perso & id_abo dans la table membre//
        $clientToMemberRequest = mysqli_query($db, "REPLACE INTO membre (id_fiche_perso, id_abo)
        VALUES ('$id_perso', '$subscriptions')");
        //Gestion d'erreur//
        if (!$clientToMemberRequest) {
            echo mysqli_error($db);
        }
        else {
            usleep(100000);?>
            <a class="navLinks"><?php echo "Passage en membre effectué !";?></a>
        <?php
        }
    }?>
    <br>
    <br>
    <a class="navLinks" href='indexClients.php'>Retour à la liste des clients</a>
    <?php mysqli_close($db); //On ferme la connexion//?>
</body>

</html>
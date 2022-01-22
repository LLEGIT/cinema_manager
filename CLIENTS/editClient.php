<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="wid_persoth=device-wid_persoth, initial-scale=1.0">
    <title>MY_CINEMA_MEMBERS</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php
    //Pour bien se connecter à la base de donnée//
    include "../CONNECTION/dbConnection.php";
    $id_perso = $_GET['viewid'];
    $records = mysqli_query($db, "SELECT * FROM fiche_personne WHERE id_perso = '$id_perso'");
    $data = mysqli_fetch_array($records);
    ?>
    <h1>MODIFIER L'UTILISATEUR</h1>
    <form method='post' action='editClient.php?viewid=<?php echo $id_perso; ?>'>
        <label for='prenom'>
            Prénom<br>
            <input type="text" name="prenom" value="<?php echo $data['prenom'] ?>" />
            <br>
        </label>
        <label for='nom'>
            Nom<br>
            <input type="text" name="nom" value="<?php echo $data['nom'] ?>" />
            <br>
        </label>
        <label for='email'>
            Mail<br>
            <input type="email" name="email" value="<?php echo $data['email'] ?>" />
            <br>
        </label>
        <label for='date_naissance'>
            Date de naissance<br>
            <input type="date" name="date_naissance"/>
            <br>
        </label>
        <label for='ville'>
            Ville<br>
            <input type="text" name="ville" value="<?php echo $data['ville'] ?>" />
            <br>
        </label>
        <label for='cpostal'>
            Code postal<br>
            <input type="text" name="cpostal" value="<?php echo $data['cpostal'] ?>" />
            <br>
        </label>
        <input type="hidden" name='id_perso' value="<?php echo $data['id_perso'] ?>"/>
        <br>
        <input name='save' type='submit' value='Enregistrer'>
    </form>
    <?php
    //On récupère les infos du formulaire grâce à $_POST//
    if (isset($_POST['save'])) {
        if (!$_POST['date_naissance']) {
            $birthdateInput = $data['date_naissance'];
        } else {
            $birthdateInput = $_POST['date_naissance'];
        }
        $prenomInput = $_POST['prenom'];
        $nomInput = $_POST['nom'];
        $mailInput = $_POST['email'];
        $villeInput = $_POST['ville'];
        $cpostalInput = $_POST['cpostal'];
        $id_perso = $_POST['id_perso'];
        //On fait une requête SQL afin de mettre à jour la table fiche_personne avec les valeurs données//
        $updateQuery = mysqli_query($db, "UPDATE fiche_personne SET prenom = '$prenomInput',
nom = '$nomInput', email = '$mailInput', date_naissance = '$birthdateInput',
ville = '$villeInput', cpostal = '$cpostalInput' WHERE id_perso = '$id_perso'");
        //Gestion d'erreur//
        if (!$updateQuery) {
            echo $birthdateInput;
            echo mysqli_error($db);
        } else {
            usleep(100000);?>
            <a class="navLinks"><?php echo "Modification effectué !"; ?></a>
        <?php
        }
    }
    ?>
    <br>
    <a class="navLinks" href="clientToMember.php?viewid=<?php echo $id_perso ?>">Passer le client en membre</a>
    <br>
    <a class="navLinks" href="viewClient.php?viewid=<?php echo $id_perso; ?>">Retour fiche personne</a>
    <br>
    <a class="navLinks" href="indexClients.php">Retour à la liste des clients</a>
    <?php mysqli_close($db); //On ferme la connexion//
    ?>
</body>

</html>
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
    include '../CONNECTION/dbConnection.php';
    $id_perso = $_GET['viewid'];
    $records = mysqli_query($db, "SELECT fiche_personne.*, membre.id_abo, abonnement.nom AS abo_nom 
FROM fiche_personne INNER JOIN membre ON fiche_personne.id_perso = membre.id_fiche_perso 
INNER JOIN abonnement ON membre.id_abo = abonnement.id_abo WHERE id_perso = $id_perso");
    $data = mysqli_fetch_array($records);
    ?>
    <h1>MODIFIER L'UTILISATEUR</h1>
    <form method='post' action="editMember.php?viewid=<?php echo $id_perso?>">
        <label for='prenom'>
            Prénom<br>
            <input type="text" name="prenom" value="<?php echo $data['prenom'] ?>" />
        </label><br>
        <label for='nom'>
            Nom<br>
            <input type="text" name="nom" value="<?php echo $data['nom'] ?>" />
        </label><br>
        <label for='email'>
            Mail<br>
            <input type="email" name="email" value="<?php echo $data['email'] ?>" />
        </label><br>
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
        </label><br>
        <label for='date_naissance'>
            Date de naissance<br>
            <input type="date" name="date_naissance"" />
        </label><br>
        <label for='ville'>
            Ville<br>
            <input type="text" name="ville" value="<?php echo $data['ville'] ?>" />
        </label><br>
        <label for='cpostal'>
            Code postal<br>
            <input type="text" name="cpostal" value="<?php echo $data['cpostal'] ?>" />
        </label>
        <input type="hidden" name='id_perso' value="<?php echo $data['id_perso']?>"/><br><br>
        <input name='save' type='submit' value='Enregistrer'>
    </form>
    <?php
    //On récupère les infos du form grâce à $_POST (comme dans editClient.php)//
    if (isset($_POST['save'])) {
        if (!$_POST['date_naissance']) {
            $birthdateInput = $data['date_naissance'];
        }
        else {
            $birthdateInput = $_POST['date_naissance'];
        }
        $prenomInput = $_POST['prenom'];
        $nomInput = $_POST['nom'];
        $mailInput = $_POST['email'];
        $subscription = $_POST['subscriptions'];
        $villeInput = $_POST['ville'];
        $cpostalInput = $_POST['cpostal'];
        $id_perso = $_POST['id_perso'];
        $updateQuery1 = mysqli_query($db, "UPDATE fiche_personne SET prenom = '$prenomInput',
        nom = '$nomInput', email = '$mailInput', date_naissance = '$birthdateInput',
        ville = '$villeInput', cpostal = '$cpostalInput' WHERE id_perso = '$id_perso'");
        $updateQuery2 = mysqli_query($db, "UPDATE membre SET id_abo = '$subscription' WHERE id_fiche_perso = '$id_perso'");
        usleep(100000);
        if (!$updateQuery1 || !$updateQuery2) {
            echo mysqli_error($db);
        }
        else {?>

            <a class="navLinks"><?php echo "Modification effectué !";?></a>
        <?php
        }
    }
    ?>
    <br>
    <a class="navLinks" href="viewMember.php?viewid=<?php echo $id_perso; ?>">Retour fiche membre</a>
    <br>
    <a class="navLinks" href="indexMembers.php">Retour liste des membres</a>
    <?php mysqli_close($db); //On ferme la connexion//?>
</body>

</html>
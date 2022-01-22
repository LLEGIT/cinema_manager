<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY_CINEMA_MEMBERS</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>FICHE MEMBRE</h1>
    <?php
    //Pour bien se connecter à la base de donnée//
    include '../CONNECTION/dbConnection.php';
    $id_perso = $_GET['viewid'];
    $records = mysqli_query($db, "SELECT fiche_personne.*, membre.id_abo, membre.id_membre, abonnement.nom AS abo_nom 
FROM fiche_personne INNER JOIN membre ON fiche_personne.id_perso = membre.id_fiche_perso 
INNER JOIN abonnement ON membre.id_abo = abonnement.id_abo WHERE id_perso = '$id_perso'");
    //Gestion d'erreur//
    if (!$records) {
        echo mysqli_error($db);
    }
    while ($data = mysqli_fetch_array($records)) {
        $id_membre = $data['id_membre'];
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
                <td>Abonnement</td>
                <td><?php echo $data['abo_nom']; ?></td>
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
        <a class="navLinks" href='editMember.php?viewid=<?php echo $id_perso ?>'>Modifier</a>
        <br>
        <a class="navLinks" href='indexMembers.php'>Retour</a><br>
        <h2>HISTORIQUE DU MEMBRE</h2>
        <a class="navLinks" href='addHistory.php?viewid=<?php echo $id_perso; ?>'>Ajouter une entrée dans l'historique</a>
        <br>
        <?php
    }
    //On fait une requête SQL afin de relier trois tables (membre, historique_membre, film) afin d'afficher l'historique du membre//
    $showHistory = mysqli_query($db, "SELECT film.titre, historique_membre.date, historique_membre.avis FROM membre 
INNER JOIN historique_membre ON membre.id_membre = historique_membre.id_membre 
INNER JOIN film ON historique_membre.id_film = film.id_film WHERE membre.id_membre = '$id_membre'
ORDER BY historique_membre.date DESC");
    $dataHistory = mysqli_fetch_array($showHistory);
    if (isset($dataHistory)) {
    ?>
        <table border='1'>
        <tr>
            <td>Titre du film</td>
            <td>Date</td>
            <td>Avis</td>
        </tr>
    <?php
    }
    while ($dataHistory = mysqli_fetch_array($showHistory)) {
        if ($dataHistory['avis'] == NULL) {
            $dataHistory['avis'] = "NULL";
        }
        ?>
            <tr>
                <td><?php echo $dataHistory['titre']; ?></td>
                <td><?php echo $dataHistory['date']; ?></td>
                <td><?php echo $dataHistory['avis']; ?></td>
            </tr>
        <?php
    }
        ?>
        </table>
        <?php mysqli_close($db); //On ferme la connexion//
        ?>
</body>

</html>
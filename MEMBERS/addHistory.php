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
    ?>
    <nav class="navBar">
        <h1>AJOUTER UN FILM A L'HISTORIQUE</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?viewid=<?php echo $id_perso; ?>">
            <input type="hidden" name="id_perso" value="<?php echo $id_perso ?>">
            <input type="text" name="search" />
            <input type="submit" name="search_button" value="Rechercher" />
        </form>
        <a href="viewMember.php?viewid=<?php echo $id_perso; ?>">Retour fiche personne</a>
        <a href="indexMembers.php">Retour liste des membres</a>
    </nav>

    <table border='1'>
        <tr>
            <td>Titre du film</td>
            <td>Laisser un avis</td>
        </tr>
        <?php
        //On get l'ID de la personne après le 'view id'//
        $id_perso = $_GET['viewid'];
        //On get ce qu'a entré l'utilisateur ou non dans la barre de recherche//
        $searchValue = $_POST['search'];
        //on en fait une requête SQL qui va sélectionner uniquement les films dont le nom/genre/distrib est ou ressemble à ce qu'a entré l'utilisateur//
        $recordsSearched = mysqli_query($db, "SELECT film.*, genre.nom AS nom_genre, 
distrib.nom AS nom_distrib FROM film INNER JOIN genre 
ON film.id_genre = genre.id_genre INNER JOIN distrib 
ON film.id_distrib = distrib.id_distrib WHERE titre LIKE '%$searchValue%'
OR distrib.nom LIKE '%$searchValue%' OR genre.nom LIKE '%$searchValue%'");
        //On affiche ça dans un tableau avec pour chaque balise td une clé précisée//
        while ($data = mysqli_fetch_array($recordsSearched)) {
        ?>
            <tr>
                <td><?php echo $data['titre']; ?></td>
                <td>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?viewid=<?php echo $id_perso; ?>">
                        <input type="hidden" name="id_film" value="<?php echo $data['id_film']; ?>">
                        <input type="hidden" name="id_perso" value="<?php echo $id_perso; ?>">
                        <input type="text" name="avis_film">
                        <input type="submit" name="select" value="Sélectionner">
                    </form>
                </td>
            </tr>
        <?php
        }
        $getMemberIdQuery = mysqli_query($db, "SELECT id_membre FROM membre INNER JOIN fiche_personne ON
membre.id_fiche_perso = fiche_personne.id_perso WHERE id_perso = $id_perso");
        $dataMemberId = mysqli_fetch_array($getMemberIdQuery);
        $memberId = $dataMemberId['id_membre'];
        $id_film = $_POST['id_film'];
        $avis_film = $_POST['avis_film'];
        if (isset($_POST['select'])) {
            $addHistoryQuery = mysqli_query($db, "INSERT INTO historique_membre (id_membre, id_film, date, avis)
VALUES ('$memberId', '$id_film', NOW(), '$avis_film')");
            if (!$addHistoryQuery) {
                echo mysqli_error($db);
            }
        }
        ?>
        <?php mysqli_close($db); //On ferme la connexion//
        ?>
</body>

</html>
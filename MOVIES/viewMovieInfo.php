<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY_CINEMA_MOVIES</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>FICHE DU FILM</h1>
    <?php
    //Pour bien se connecter à la base de donnée//
    include "../CONNECTION/dbConnection.php";
    $movieId = $_GET['viewid'];
    //Requête SQL afin de n'afficher que les infos reliées à la clé donné par $movieId//
    $records = mysqli_query($db, "SELECT film.*, genre.nom AS nom_genre, 
    distrib.nom AS nom_distrib FROM film LEFT JOIN genre 
    ON film.id_genre = genre.id_genre LEFT JOIN distrib 
    ON film.id_distrib = distrib.id_distrib WHERE id_film = '$movieId'");
    //On affiche alors le résultat (en array) dans un tableau HTML avec chaque clé dans une balise <td>//
    while ($data = mysqli_fetch_array($records)) {
    ?>
        <table border="1">
            <tr>
                <td>Titre du film</td>
                <td><?php echo $data['titre']; ?></td>
            </tr>
            <tr>
                <td>Genre</td>
                <td><?php echo $data['nom_genre']; ?></td>
            </tr>
            <tr>
                <td>Durée du film en minutes</td>
                <td><?php echo $data['duree_min']; ?></td>
            </tr>
            <tr>
                <td>Distributeur</td>
                <td><?php echo $data['nom_distrib']; ?></td>
            </tr>
            <tr>
                <td>Année de production</td>
                <td><?php echo $data['annee_prod']; ?></td>
            </tr>
            <tr>
                <td>Résumé</td>
                <td><?php echo $data['resum']; ?></td>
            </tr>
        </table>
        <br>
        <a class="navLinks" href='indexMovies.php'>RETOUR</a>
    <?php
    }
    ?>
    </table>
    <?php mysqli_close($db); //On ferme la connexion//?>
</body>

</html>
<!DOCTYPE html>
<html lang="fr">

<head>
  <title>MY_CINEMA_MOVIES</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  <?php
  //Pour bien se connecter à la base de donnée//
  include "../CONNECTION/dbConnection.php";
  ?>
  <nav class="navBar">
    <h1>FILMS</h1>
    <form method="post" action="indexMovies.php">
    <input type="text" placeholder="titre/genre..." name="search" />
    <input type="submit" name="searchByWord" value="Rechercher" />
  </form>
  <form method="post" action="indexMovies.php">
    <label for="date_projection">Date de début de projection</label>
    <input type="date" name="date_projection">
    <input type="submit" name="searchByDate" value="Rechercher"/>
  </form>
    <a href="../index.html">ACCUEIL</a>
  </nav>

  <br>
  <?php
  //On get ce qu'a entré l'utilisateur ou non dans la barre de recherche//
  $searchValue = $_POST['search'];
  if (isset($_POST['searchByWord']) || isset($_POST['searchByDate'])) {
    if (isset($_POST['date_projection'])) {
      $date_projection = $_POST['date_projection'];
    }
  ?>
    <table border='1'>
      <tr>
        <td>Titre du film</td>
        <td>Genre</td>
        <td>Année de production</td>
        <td>Dates de projection</td>
        <td>Prochaine séance</td>
        <td>Voir plus</td>
        <td>Édition</td>
      </tr>
    <?php
    //on en fait une requête SQL qui va sélectionner uniquement les films dont le nom/genre/distrib est ou ressemble à ce qu'a entré l'utilisateur//
    if (!$date_projection) {
      $recordsSearched = mysqli_query($db, "SELECT film.*, genre.nom AS nom_genre, grille_programme.debut_seance, salle.nom_salle,
      distrib.nom AS nom_distrib FROM film LEFT JOIN genre ON film.id_genre = genre.id_genre LEFT JOIN distrib 
      ON film.id_distrib = distrib.id_distrib LEFT JOIN grille_programme ON film.id_film = grille_programme.id_film LEFT JOIN salle ON
      grille_programme.id_salle = salle.id_salle WHERE film.titre LIKE '%$searchValue%' OR distrib.nom LIKE '%$searchValue%' OR genre.nom LIKE '%$searchValue%' 
      ORDER BY id_film");
    }
    elseif ($date_projection) {
      $recordsSearched = mysqli_query($db, "SELECT film.*, genre.nom AS nom_genre, grille_programme.debut_seance, salle.nom_salle,
      distrib.nom AS nom_distrib FROM film LEFT JOIN genre ON film.id_genre = genre.id_genre LEFT JOIN distrib 
      ON film.id_distrib = distrib.id_distrib LEFT JOIN grille_programme ON film.id_film = grille_programme.id_film LEFT JOIN salle ON
      grille_programme.id_salle = salle.id_salle WHERE DATEDIFF(date_debut_affiche,'$date_projection') >= 0");
    }
  }
  if (!$recordsSearched) {
    echo mysqli_error($db);
  }
  //On affiche ça dans un tableau avec pour chaque balise td une clé précisée//
  while ($data = mysqli_fetch_array($recordsSearched)) {
    ?>
      <tr>
        <td><?php echo $data['titre']; ?></td>
        <td><?php echo $data['nom_genre']; ?></td>
        <td><?php echo $data['annee_prod']; ?></td>
        <td><?php echo $data['date_debut_affiche'] . " au " . $data['date_fin_affiche']; ?></td>
        <td><?php echo $data['debut_seance']; ?> <br><?php echo $data['nom_salle']; ?></td>
        <td><a href="viewMovieInfo.php?viewid=<?php echo $data['id_film']; ?>" class="view" title="View" data-toggle="tooltip">Fiche du film</a></td>
        <td><a href="addMovieSeance.php?viewid=<?php echo $data['id_film'] ?>">Ajouter une séance</a>
      </tr>
    <?php
  }
    ?>
    </table>
    <?php mysqli_close($db); //On ferme la connexion//
    ?>

</body>

</html>
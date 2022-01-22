<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY_CINEMA_MEMBERS</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php
    include '../CONNECTION/dbConnection.php';
    $id_film = $_GET['viewid'];
    ?>
    <h1>Ajouter une séance</h1>
    <form method="post" action="addMovieSeance.php?viewid=<?php echo $id_film; ?>">
        <label for="seance_date_beginning">Date & heure de début</label><br>
        <input name="seance_date_beginning" type="datetime-local" required><br><br>
        <label for="seance_date_end">Fin de la séance</label><br>
        <input name="seance_date_end" type="datetime-local" required><br><br>
        <select name="room_choice" required><br><br>
            <option value="">--Veuillez choisir une salle--</option>
            <option value="0">Montana</option>
            <option value="1">Highscore</option>
            <option value="2">Salle 3</option>
            <option value="3">Astek</option>
            <option value="4">Gecko</option>
            <option value="5">Azure</option>
            <option value="6">Toshiba</option>
            <option value="7">Salle 14</option>
            <option value="8">Asus</option>
            <option value="9">Salle 16</option>
            <option value="10">Microsoft</option>
            <option value="11">VIP</option>
            <option value="12">Golden</option>
            <option value="13">Salle 23</option>
            <option value="14">Lenovo</option>
            <option value="15">Salle 31</option>
            <option value="16">Huawei</option>
        </select><br><br>
        <input type="submit" name="submit" value="Ajouter">
    </form><br>
    <?php
    if (isset($_POST['submit'])) {
        $seance_date_debut = $_POST['seance_date_beginning'];
        $seance_date_fin = $_POST['seance_date_end'];
        $room_choice = $_POST['room_choice'];
        $addSeanceQuery = mysqli_query($db, "REPLACE INTO grille_programme
        (id_film, id_salle, id_fiche_perso_ouvreur, id_fiche_perso_technicien, 
        id_fiche_perso_menage, debut_seance, fin_seance) VALUES ('$id_film', '$room_choice', '1', '1', '1', '$seance_date_debut', '$seance_date_fin')");
        if (!$addSeanceQuery) {
            echo mysqli_error($db);
        }
    }
    ?>
    <br>
    <a class="navLinks" href="indexMovies.php">Revenir à la liste des films</a>
</body>

</html>
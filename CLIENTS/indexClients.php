<!DOCTYPE html>
<html lang="fr">

<head>
  <title>MY_CINEMA_CLIENTS</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../style.css">
  <link rel="icon" href="../icon_cinema.png">
</head>

<body>
  <?php
  //Pour bien se connecter à la base de donnée//
  include "../CONNECTION/dbConnection.php";
  ?>

  <nav class="navBar">
    <h1>CLIENTS</h1>
    <form method="post" action="indexClients.php">
      <input type="text" placeholder="nom/prénom..." name="search" />
      <input type="submit" value="Rechercher" />
    </form>
    <a href="addClient.php">➕ AJOUTER UN CLIENT</a>
    <a href="../index.html">ACCUEIL</a>
  </nav>
  <br>
    <?php
    //On obtient la valeur donné par l'utilisateur via $_POST//
    $searchValue = $_POST['search'];
    if (isset($searchValue)) {
    $str = $searchValue;
    //Si l'utilisateur donne prénom & nom (séparé d'un espace)//
    if (strpos($str, ' ') !== false) {
      $fullname = true;
      $strPos = strpos($str, ' ');
      $strFirstName = substr($str, 0, $strPos);
      $strLastName = substr($str, ($strPos + 1));
    }
    //Si un seul mot est donné// 
    else {
      $fullname = false;
      $strFirstName = $str;
      $strLastName = $str;
    }
    //Si l'utilisateur donne un nom complet//
    if ($fullname == true) {
      $recordsSearched = mysqli_query($db, "SELECT * FROM fiche_personne WHERE prenom LIKE '%$strFirstName%' 
AND nom LIKE '%$strLastName%'");
    } else {
      $recordsSearched = mysqli_query($db, "SELECT * FROM fiche_personne WHERE prenom LIKE '%$strFirstName%' 
OR nom LIKE '%$strLastName%'");
    }
    ?>
    <table border='1'>
    <tr>
      <td>Prénom</td>
      <td>Nom</td>
      <td>Mail</td>
      <td>Édition</td>
    </tr>
    <?php
    }
    //On affiche alors les infos de tous les clients trouvés dans un tableau avec pour chaque td une clé spécifique//
    while ($data = mysqli_fetch_array($recordsSearched)) {
    ?>
      <tr>
        <td><?php echo $data['prenom']; ?></td>
        <td><?php echo $data['nom']; ?></td>
        <td><?php echo $data['email']; ?></td>
        <td>
          <a href="viewClient.php?viewid=<?php echo $data['id_perso']; ?>" class="view" title="View" data-toggle="tooltip">Voir</a> |
          <a href="editClient.php?viewid=<?php echo $data['id_perso']; ?>" class="update" title="Update" data-toggle="tooltip">Modifier</a> |
          <a href="removeClient.php?viewid=<?php echo $data['id_perso']; ?>" class="update" title="Update" data-toggle="tooltip">Supprimer</a>
        </td>
      </tr>
    <?php
    }
    ?>
  </table>
  <?php mysqli_close($db); //On ferme la connexion//
  ?>
</body>

</html>
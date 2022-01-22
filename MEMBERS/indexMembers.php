<!DOCTYPE html>
<html lang="fr">

<head>
  <title>MY_CINEMA_MEMBERS</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  <?php
  //Pour bien se connecter à la base de donnée//
  include "../CONNECTION/dbConnection.php";
  // Using database connection file here
  ?>

  <nav class="navBar">
    <h1>MEMBRES (AVEC ABONNEMENTS)</h1>
    <form method="post" action="indexMembers.php">
      <input type="text" placeholder="prénom/nom..." name="search" />
      <input type="submit" value="Rechercher" />
    </form>
    <a href="../index.html">ACCUEIL</a>
  </nav>
  <br>
  <?php
  $searchValue = $_POST['search'];
  if (isset($searchValue)) {
    $str = $searchValue;
    if (strpos($str, ' ') !== false) {
      $fullname = true;
      $strPos = strpos($str, ' ');
      $strFirstName = substr($str, 0, $strPos);
      $strLastName = substr($str, ($strPos + 1));
    } else {
      $fullname = false;
      $strFirstName = $str;
      $strLastName = $str;
    }
    if ($fullname == true) {
      $recordsSearched = mysqli_query($db, "SELECT fiche_personne.*, membre.id_abo, abonnement.nom AS abo_nom 
FROM fiche_personne INNER JOIN membre ON fiche_personne.id_perso = membre.id_fiche_perso 
INNER JOIN abonnement ON membre.id_abo = abonnement.id_abo WHERE fiche_personne.prenom LIKE '%$strFirstName%' 
AND fiche_personne.nom LIKE '%$strLastName%'");
    } else {
      $recordsSearched = mysqli_query($db, "SELECT fiche_personne.*, membre.id_abo, abonnement.nom AS abo_nom 
FROM fiche_personne INNER JOIN membre ON fiche_personne.id_perso = membre.id_fiche_perso 
INNER JOIN abonnement ON membre.id_abo = abonnement.id_abo WHERE fiche_personne.prenom LIKE '%$strFirstName%' 
OR fiche_personne.nom LIKE '%$strLastName%'");
    }
  ?>
    <table border='1'>
      <tr>
        <td>Prénom</td>
        <td>Nom</td>
        <td>Mail</td>
        <td>Abonnement</td>
        <td>Édition</td>
      </tr>
    <?php
  }

  while ($data = mysqli_fetch_array($recordsSearched)) {
    ?>
      <tr>
        <td><?php echo $data['prenom']; ?></td>
        <td><?php echo $data['nom']; ?></td>
        <td><?php echo $data['email']; ?></td>
        <td><?php echo $data['abo_nom']; ?></td>
        <td>
          <a href="viewMember.php?viewid=<?php echo $data['id_perso']; ?>" class="view" title="View" data-toggle="tooltip">Voir</a> |
          <a href="editMember.php?viewid=<?php echo $data['id_perso']; ?>" class="update" title="Update" data-toggle="tooltip">Modifier</a> |
          <a href="removeMember.php?viewid=<?php echo $data['id_perso']; ?>" class="update" title="Update" data-toggle="tooltip">Supprimer</a>
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
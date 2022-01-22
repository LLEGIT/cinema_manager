<!DOCTYPE html>
<html lang="fr">

<head>
  <title>MY_CINEMA_SUBSCRIPTIONS</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  <?php
  //Pour bien se connecter à la DB//
  include '../CONNECTION/dbConnection.php';
  ?>
  <nav class="navBar">
    <h1>ABONNEMENTS</h1>
    <a href="../index.html">ACCUEIL</a>
  </nav>

  <table border='1'>
    <tr>
      <td>Nom</td>
      <td>Prestations</td>
      <td>Prix(€)</td>
      <td>Durée abonnement (en jours)</td>
    </tr>
    <?php
    //Requête SQL sur la DB pour afficher les différents types d'abonnements//
    $recordsSearched = mysqli_query($db, "SELECT * FROM abonnement");
    //On affiche alors le résultat (en array) dans un tableau HTML avec chaque clé dans une balise <td>//
    while ($data = mysqli_fetch_array($recordsSearched)) {
    ?>
      <tr>
        <td><?php echo $data['nom']; ?></td>
        <td><?php echo $data['resum']; ?></td>
        <td><?php echo $data['prix']; ?></td>
        <td><?php echo $data['duree_abo']; ?></td>
      </tr>
    <?php
    }
    ?>
  </table>
  <?php mysqli_close($db); // On ferme la connexion avec la DB// 
  ?>

</body>

</html>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="wid_persoth=device-wid_persoth, initial-scale=1.0">
    <title>MY_CINEMA_CLIENTS</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php 
    //Pour bien se connecter à la base de donnée//
    include "../CONNECTION/dbConnection.php";?>
    <h1>AJOUTER UN CLIENT</h1>
    <form method='post' action='addClient.php'>
        <label for='prenom'>
            Prénom<br>
            <input type="text" name="prenom" placeholder="Jean..."/>
            <br>
        </label>
        <label for='nom'>
            Nom<br>
            <input type="text" name="nom" placeholder="Schwarzeneger..."/>
            <br>
        </label>
        <label for='email'>
            Mail<br>
            <input type="email" name="email" placeholder="test@test.com..."/>
            <br>
        </label>
        <label for='date_naissance'>
            Date de naissance<br>
            <input type="date" name="date_naissance" required/>
            <br>
        </label>
        <label for='ville'>
            Ville<br>
            <input type="text" name="ville" placeholder="Quimper..."/>
            <br>
</label>
        <label for='cpostal'>
            Code postal<br>
            <input type="text" name="cpostal" placeholder="33160..."/>
            <br>
        </label>
        <br>
        <input name='save' type='submit' value='➕ Ajouter'>
    </form>
    <?php
    //Si le bouton ajouter est pressé, on obtient les valeurs du formulaire via $_POST//
    if (isset($_POST['save'])) {
        $prenomInput = $_POST['prenom'];
        $nomInput = $_POST['nom'];
        $mailInput = $_POST['email'];
        $date_naissanceInput = $_POST['date_naissance'];
        $villeInput = $_POST['ville'];
        $cpostalInput = $_POST['cpostal'];
        //Requête SQL afin d'ajouter les valeurs transmises via le formulaire dans une nouvelle ligne (pas besoin de donner un id car auto_incrémenté par défaut//
        $addQuery = mysqli_query($db, "INSERT INTO fiche_personne (nom, prenom, date_naissance, email, cpostal, ville) 
        VALUES ('$nomInput', '$prenomInput', '$date_naissanceInput', '$mailInput', '$cpostalInput', '$villeInput')");
        if ($addQuery) {
            usleep(100000);?>
            <br>
            <a class="navLinks"><?php echo "Ajout de M./Mme $prenomInput $nomInput!";?></a>
        <?php
        }
        //Gestion d'erreur//
        elseif (!$addQuery) {
            print_r(mysqli_error($db));
        }
    }
    ?>
    <br>
    <a class="navLinks" href="indexClients.php">Retour à la liste des clients</a>
    <?php mysqli_close($db); //On ferme la connexion//?>
</body>

</html>
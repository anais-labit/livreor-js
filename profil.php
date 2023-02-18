<?php
session_start();
require_once './includes/User_pdo.php';

$login = $_SESSION['login'];
var_dump($_SESSION);

if (isset($_POST['submit'])) {
    $update = new User_pdo;
    $update->update($login);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>

<body>
    <?php require_once "./includes/header.php" ?>
    <div class="page">

        <?php
        // salut personnalisé s'il y a un login
        if (isset($_SESSION['login'])) {
            echo " <h1> Modifier votre profil " . ucwords($login) . "</h1>";
        } else {
            echo "<h1> Salut ! </h1>";
        }
        ?>

        <div class="formContainer">
            <form action="profil.php" method="post">
                <input type="text" name="login" placeholder="Login : <?= $login ?> ou nouveau ?" required>
                <input type="password" name="confpwd" placeholder="Ancien mot de passe" required>
                <input type="password" name="newpwd" placeholder="Nouveau Mot de passe" required>
                <input type="password" name="newpwd2" placeholder="Confirmation" required>
                <input type="submit" name="submit" value="Sauvegarder les changements">
            </form>
        </div>
    </div>
    <?php require_once "./includes/footer.php" ?>
</body>

</html>
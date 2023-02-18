<?php
require_once './includes/User_pdo.php';

if (isset($_GET['action']) && $_GET['action'] == 'deco') {
    $stm = new User_pdo();
    $deco = $stm->deco();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
    <title>Header</title>
</head>

<body>

    <header>

        <nav>
            <div class="navContainer">
                <ul>
                    <?php if (isset($_SESSION['login'])) {  ?>
                        <ul>
                            <li><a id="livre" href="livre-or.php">Livre d'or</a></li>
                            <li><a id="commentaire" href="commentaire.php">Ajouter un commentaire</a></li>
                            <li><a id="profil" href="profil.php">Modifier mon profil</a></li>
                            <li><a id="deconnexion" href="index.php?action=deco">Déconnexion</a></li>
                        </ul>
                    <?php } else {  ?>
                        <ul>
                            <li><a id="inscription" href="index.php">Inscription</a></li>
                            <li><a id="signIn" href="index.php">Connexion</a></li>
                            <li><a id="livre" href="livre-or.php">Livre d'or</a></li>
                        </ul>
                    <?php }; ?>

                </ul>
            </div>

        </nav>
    </header>

</body>

</html>
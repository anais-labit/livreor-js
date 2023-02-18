<?php
session_start();
require_once './includes/User_pdo.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
</head>

<body>
    <?php require_once "./includes/header.php" ?>
    <div class="page">
        <div class="livreContainer">
            <h1>Livre d'or</h1>
            <table>
                <tbody>
                    <td>
                        <?php $req = new User_pdo();
                        $req->displayComment();
                        ?>
                    </td>
                </tbody>
            </table>
        </div>
        <div class="commentaireContainer">
            <?php
            // donner la possibilité de laisser un commentaire si on est connécté
            if (isset($_SESSION['login'])) { ?>
                <button><a href="commentaire.php">Laisser un commentaire</a></button>
            <?php } ?>
        </div>
    </div>
    <?php require_once "./includes/footer.php" ?>
</body>

</html>
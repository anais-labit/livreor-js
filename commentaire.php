<?php
session_start();
require_once './includes/User_pdo.php';

if (isset($_POST['comment'])) {
    $comment = new User_pdo();
    $id = $_SESSION['id'];
    $comment->addComment($id);
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
    <title>Ajout de commentaire</title>
</head>

<body>
    <?php require_once './includes/header.php'; ?>
    <!-- <div class="page" id="page"> -->
    <div id="container" class="container">
        <form action="" method="post" id="commentForm">
            <h1>Ajouter un commentaire</h1>
            <textarea name="comment" id="comment" placeholder="Écrire ici..." style="height: 100px" required></textarea>
            <button type="submit" id="post">Publier votre commentaire</button>
            <span id="posting"></span>
        </form>
    </div>
    <!-- </div> -->
    <script async src="./JS/comment.js"></script>

    <?php require_once './includes/footer.php'; ?>
</body>

</html>
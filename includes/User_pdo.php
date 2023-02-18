<?php

class User_pdo
{
    private $PDO;
    private ?int $id = null;
    public ?string $login = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $password2 = null;


    // bonne pratique avec un getter et un setteur, pour des raisons d'encapsulation
    // ici le typage précise soit ?null soit string

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): User_pdo
    {
        $this->id = $id;
        return $this;
    }

    // codé comme ça, les valeurs associées au nouvel utilisateur que l'on instancie 
    // pourront être settées 
    // comme suit à l'extérieur (dans index.php):

    // $newUser = new User_pdo;
    // $user1->setId(1);

    // et comme ça si je suis dans (une autre fonction de) ma classe :
    // $this->setId(1)

    public function __construct()
    {
        $DB_DSN = 'mysql:host=localhost; dbname=livreor-js';
        $DB_USER = 'root';
        $DB_PASS = '';

        try {
            $this->PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);
            // echo 'Connexion établie';
            // return TRUE;
        } catch (PDOException $e) {
            die('ERREUR :' . $e->getMessage());
        }
    }

    public function register(string $login, string $email, string $password, string $password2)
    {

        $this->PDO;
        // On vérifie si l'utilisateur existe déjà en DB
        $check = $this->PDO->prepare('SELECT login, password FROM utilisateurs WHERE login = ?');
        $check->execute(array($login));
        $data = $check->fetch();
        $row = $check->rowCount();

        //s'il n'existe pas, que les pwd matchent, on créé l'user en DB
        if ($row === 0) {
            if ($password === $password2) {
                $password = password_hash($password, PASSWORD_BCRYPT);
                $insert = $this->PDO->prepare('INSERT INTO utilisateurs(login, email, password) VALUES(:login, :email, :password)');
                $insert->execute(array(
                    'login' => $login,
                    'email' => $email,
                    'password' => $password,
                ));
                // et on affiche le message d'inscription
                echo 'Inscription réussie';
            }
        }
    }
    public function signIn(string $login, string $password)
    {
        $this->PDO;
        // On vérifie si l'utilisateur existe
        $check = $this->PDO->prepare('SELECT id, login, email, password FROM utilisateurs WHERE login = ?');
        $check->execute(array($login));
        $data = $check->fetch();
        $row = $check->rowCount();
        // var_dump($row);
        // s'il existe, on retransforme son pwd et on fait afficher le message de succès de connexion
        if ($row === 1) {
            $hashedPassword = $data['password'];
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['login'] = $login;
                $_SESSION['id'] = $data[0];
                $_SESSION['password'] = $password;
                echo 'Connexion réussie';
            }
        }
    }
    public function deco()
    {
        session_start();
        unset($_SESSION);
        session_destroy();
        header('refresh:3; url= index.php');
    }

    public function addComment($id)
    {
        $this->PDO;
        // On va chercher les infos de l'utilisateur 
        $check = $this->PDO->prepare('SELECT id, login, password FROM utilisateurs WHERE id = ?');
        $check->execute([$id]);
        $data = $check->fetch();
        $_SESSION['id'] = $data[0];

        // definir le format de la date compatible avec la DB
        $date = date('Y-m-d H:i:s');
        // création de la variable commentaire issue du POST en le formatant de telle sorte à ce que l'on puisse mettre des ' et caractères spéciaux dans le post
        $commentaire = htmlspecialchars($_POST["comment"]);

        // requête d'ajout de commentaire
        $add = $this->PDO->prepare("INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES ('$commentaire', '$id', '$date')");
        $add->execute();
        echo "Félicitations, votre commentaire a bien été ajouté !";
    }


    public function displayComment()
    {
        $this->PDO;
        // On va chercher les commentaires 
        $check = $this->PDO->prepare("SELECT DATE_FORMAT(commentaires.date, '%d/%m/%Y'), utilisateurs.login, commentaires.commentaire FROM commentaires INNER JOIN utilisateurs ON commentaires.id_utilisateur=utilisateurs.id ORDER BY date DESC");
        $check->execute();
        // var_dump($data);
        $displayComm = $check->fetchAll();
        $i = -1;
        // boucle 1 qui parcourt les différents tableaux de commentaire
        foreach ($displayComm as $ligne) {
            // boucle 2 qui parcourt les cases du tableau
            foreach ($ligne as $value) {
                $i++;
                // echo les valeurs du tableau en fonction de leur index (0 = date, 1=login, 2=commentaire)
                echo 'Posté le ' . $displayComm[$i][0] . ' par ' . ucwords($displayComm[$i][1]) . "<br>" . $displayComm[$i][2] . '</p><br>';
                // arrêter lorsqu'il n'y a plus de valeur à parcourir
                break;
            }
        }
    }

    public function update($login)
    {
        $this->PDO;
        $check = $this->PDO->prepare('SELECT login, password FROM utilisateurs WHERE login = ?');
        $check->execute([$login]);
        $displayInfo = $check->fetchAll();
        var_dump($_SESSION);


        // si le formulaire est envoyé
        if (isset($_POST['submit'])) {
            $id = $_SESSION['id'];
            // var_dump($_SESSION);
            // les post deviennent les nouvelles valeurs
            $confpwd = ($_POST['confpwd']);
            $newpwd2 = ($_POST['newpwd2']);
            $newpwd = ($_POST['newpwd']);
            $newlogin = ($_POST['login']);

            // si l'ancien pwd est le bon et que les nouveaux pwd correspondent
            if (($confpwd == $_SESSION['password']) && ($newpwd == $newpwd2)) {
                // faire la requete de mise à jour de la db avec les nouvelles valeurs

                $upInfo = $this->PDO->query("UPDATE utilisateurs SET login ='$newlogin', password = '$newpwd' WHERE id= $id");
                echo "Les modifications ont bien été prises en compte";
                // et sauver les nouvelles valeurs
                $_SESSION['login'] = $newlogin;
                $_SESSION['pwd'] = $newpwd;
                header("Refresh:2");
            } else {
                echo "Mots de passe invalides";
            }
        }
    }
}

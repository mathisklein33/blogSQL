
<?php
require __DIR__ . '/../../include/configPHP.php';
session_start();
$message = "";

if(count($_POST) > 0) {
    $con = mysqli_connect('127.0.0.1', 'root', '', 'blog', 3306) or die('Unable To connect');

    // Vérifier si l'email existe déjà
    $stmt = $con->prepare("SELECT id FROM `user` WHERE email=?");
    $stmt->bind_param("s", $_POST["userEmail"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $message = "Email déjà utilisé !";
    } else {
        // Insérer le nouvel utilisateur
        $stmt = $con->prepare("INSERT INTO `user` (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $_POST["userName"], $_POST["userEmail"], $_POST["userPassword"]);
        if($stmt->execute()) {
            $message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } else {
            $message = "Erreur lors de l'inscription !";
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <script src="public/js/scripts.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>
<header class="d-flex align-items-center d-flex justify-content-center p-3">
    <h2>inscription</h2>
</header>
<div class="d-flex align-items-center d-flex justify-content-center p-3 border">
    <form action="#" method="POST">
        <div class="p-2">
        <input class="form-control" type="text" name="userName" placeholder="Votre nom">
        </div>
        <div class="p-2">
        <input class="form-control" type="text" name="userEmail" placeholder="Votre email">
        </div>
        <div class="p-2">
        <input class="form-control" type="password" name="userPassword" placeholder="Votre mot de passe">
            </div>
        <div class="p-2">
        <button class="btn btn-primary btn-block mb-4" type="submit">S'inscrire</button>
        </div>
    </form>
</div>

<?php if($message != "") { echo "<p>$message</p>"; } ?>

<footer class="border-top">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <ul class="list-inline text-center">
                    <li class="list-inline-item">
                        <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                    </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                    </span>
                        </a>
                    </li>
                </ul>
                <div class="small text-center text-muted fst-italic">Copyright &copy; Your Website 2023</div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
<!-- Core theme JS-->
<script src="public/js/scripts.js"></script>
</body>
</html>


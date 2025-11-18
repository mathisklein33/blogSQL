<?php
session_start();

if(isset($_POST['connection'])) {
    if (empty($_POST['Email'])) {
        echo "Le champ Email est vide.";
    } else {

    }
    // on vérifie maintenant si le champ "Mot de passe" n'est pas vide"
    if (empty($_POST['mdp'])) {
        echo "Le champ Mot de passe est vide.";
    } else {
        $Email = htmlentities($_POST['Email'], ENT_QUOTES, "UTF-8");
        $MotDePasse = htmlentities($_POST['mdp'], ENT_QUOTES, "UTF-8");
        $mysqli = mysqli_connect("localhost", "root", "", "blog");
        if (!$mysqli) {
            echo "Erreur de connexion à la base de données.";
        } else {
            $Requete = mysqli_query($mysqli, "SELECT * FROM membres WHERE pseudo = '" . $Email . "' AND mdp = '" . $MotDePasse . "'");
            if (mysqli_num_rows($Requete) == 0) {
                echo "Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.";
            } else {
                //
                //
                $_SESSION['pseudo'] = $Email;
                echo "Vous êtes à présent connecté !";
            }
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
    <h2>Connection</h2>
</header>

<div class="d-flex align-items-center d-flex justify-content-center p-3 border">
    <form method="POST" action="">

        <div class="form-outline mb-4">
            <input type="email" class="form-control" name="Email" required />
            <label class="form-label">Email address</label>
        </div>

        <div class="form-outline mb-4">
            <input type="password" class="form-control" name="mdp" required />
            <label class="form-label">Password</label>
        </div>

        <button type="submit" class="btn btn-primary btn-block mb-4" name="connection">
            Sign in
        </button>

        <a href="register.php" class="btn btn-primary btn-block mb-4">
            Register
        </a>
    </form>


</div>

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

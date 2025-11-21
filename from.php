<?php


if (isset($_POST['connection'])) {

    // Vérifier l'email
    if (empty($_POST['email'])) {
        echo "Le champ Email est vide.";
        exit;
    }

    // Vérifier le mot de passe
    if (empty($_POST['password'])) {
        echo "Le champ Mot de passe est vide.";
        exit;
    }

    // Récupération correcte
    $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
    $password = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");

    // Connexion DB
    $mysqli = mysqli_connect("localhost", "root", "", "blog2");

    if (!$mysqli) {
        echo "Erreur de connexion à la base de données.";
        exit;
    }

    // Requête sécurisée
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification utilisateur
    if ($result->num_rows === 0) {
        echo "Email ou mot de passe incorrect.";
    } else {

        // ⚠️ SESSION DÉMARRÉE UNIQUEMENT MAINTENANT
        session_start();

        // Connexion OK
        $_SESSION['email'] = $email;

        echo "Vous êtes à présent connecté !";
        if ($result->num_rows === 1) {
            $_SESSION['email'] = $email;
            header("Location: user.php");
            exit();
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
            <input type="email" class="form-control" name="email" required />
            <label class="form-label">Email address</label>
        </div>

        <div class="form-outline mb-4">
            <input type="password" class="form-control" name="password" required />
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

<?php
include 'include/footer.php';
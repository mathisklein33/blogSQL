
<?php
$message = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Connexion
    $con = mysqli_connect("localhost", "root", "", "blog2");

    if (!$con) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    // Récupérer les données
    $username  = trim($_POST["username"]);
    $email     = trim($_POST["email"]);
    $password  = trim($_POST["password"]);

    // Vérifications
    if (empty($username) || empty($email) || empty($password)) {
        $message = "Tous les champs doivent être remplis !";
    } else {

        // Vérifier si mail existe déjà
        $stmt = $con->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Email déjà utilisé !";
        } else {

            // Rôle par défaut = 2 (user)
            $role_id = 2;

            // Insérer utilisateur
            $stmt = $con->prepare("
                INSERT INTO user (username, email, password, role_id)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("sssi", $username, $email, $password, $role_id);

            if ($stmt->execute()) {
                $message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            } else {
                $message = "Erreur lors de l'inscription : " . $stmt->error;
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
    <h2>inscription</h2>
</header>
<div class="d-flex align-items-center d-flex justify-content-center p-3 border">
    <form action="#" method="POST">
        <div class="p-2">
        <input class="form-control" type="text" name="username" placeholder="Votre nom">
        </div>
        <div class="p-2">
        <input class="form-control" type="text" name="email" placeholder="Votre email">
        </div>
        <div class="p-2">
        <input class="form-control" type="password" name="password" placeholder="Votre mot de passe">
            </div>
        <div class="p-2">
        <button class="btn btn-primary btn-block mb-4" type="submit">S'inscrire</button>
        </div>
    </form>
</div>

<?php if($message != "") { echo "<p>$message</p>"; }

include 'include/footer.php';
?>





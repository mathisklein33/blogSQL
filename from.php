<?php
session_start();

$message = "";

if (isset($_POST['connection'])) {

    // Vérifier l'email
    if (empty($_POST['email'])) {
        $message = "Le champ Email est vide.";
    }

    // Vérifier le mot de passe
    elseif (empty($_POST['password'])) {
        $message = "Le champ Mot de passe est vide.";
    }

    else {
        // Récupérer champs
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Connexion DB
        $mysqli = mysqli_connect("localhost", "root", "", "blog2");

        if (!$mysqli) {
            die("Erreur de connexion à la base de données.");
        }

        // Récupérer utilisateur PAR EMAIL
        $stmt = $mysqli->prepare("
            SELECT id, email, password, username, role_id 
            FROM user 
            WHERE email = ?
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $message = "Email incorrect.";
        } else {
            $user = $result->fetch_assoc();

            // Vérifier mot de passe haché
            if (!password_verify($password, $user['password'])) {
                $message = "Mot de passe incorrect.";
            } else {

                // ---- SUCCESS : ON CONNECTE L’UTILISATEUR ----
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['email']    = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role_id']  = $user['role_id']; // ⭐ IMPORTANT

                // Redirection vers page utilisateur
                header("Location: user.php");
                exit;
            }
        }
    }
}
?>
    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Connexion</title>
        <link rel="stylesheet" href="public/css/styles.css">
        <script src="public/js/scripts.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

    <header class="d-flex align-items-center justify-content-center p-3">
        <h2>Connexion</h2>
    </header>

    <div class="d-flex align-items-center justify-content-center p-3 border">

        <form method="POST">
            <div class="form-outline mb-4">
                <input type="email" class="form-control" name="email" required />
                <label class="form-label">Email</label>
            </div>

            <div class="form-outline mb-4">
                <input type="password" class="form-control" name="password" required />
                <label class="form-label">Mot de passe</label>
            </div>

            <button type="submit" class="btn btn-primary btn-block mb-4" name="connection">
                Connexion
            </button>

            <a href="register.php" class="btn btn-secondary btn-block mb-4">
                S'inscrire
            </a>
        </form>
    </div>

<?php
// Affichage message d’erreur
if (!empty($message)) {
    echo "<p class='text-center text-danger mt-3'>$message</p>";
}

include 'include/footer.php';
?>
<?php

include 'include/header.php';

$con = mysqli_connect("localhost", "root", "", "blog2");

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: from.php");
    exit();
}

// Récupérer l'ID de l'utilisateur depuis le mail
$email = $_SESSION['email'];

$stmt = $con->prepare("SELECT id FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $user_id = $row['id'];
    $_SESSION['user_id'] = $user_id; // on le met dans la session pour plus tard
} else {
    die("Erreur : utilisateur introuvable.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupération des données POST
    $titre = substr($_POST['Titre'], 0, 45);  // limite 45
    $contenu = substr($_POST['contenu'], 0, 255); // limite 255
    $date = $_POST['datetime'];
    $category_name = trim($_POST['category']);

    // Vérifier si la catégorie existe
    $stmt = $con->prepare("SELECT category_id FROM category WHERE name = ?");
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $category_id = $row["category_id"];
    } else {
        // Créer la catégorie
        $stmt = $con->prepare("INSERT INTO category (name) VALUES (?)");
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        $category_id = $stmt->insert_id;
    }

    // Créer le post
    $stmt = $con->prepare("INSERT INTO post (Titre, contenu, datetime, user_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $titre, $contenu, $date, $user_id);
    $stmt->execute();
    $post_id = $stmt->insert_id;

    // Lier catégorie ↔ post
    $stmt = $con->prepare("INSERT INTO category_has_post (category_id, post_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $category_id, $post_id);
    $stmt->execute();

    echo "<p style='color:green'>Post créé avec succès !</p>";
}

?>


    <section class="container py-4">
        <h2 class="mb-4">Créer un post</h2>

        <form action="" method="POST">
            <div class="p-2">
                <input class="form-control" type="text" name="Titre" placeholder="Titre" required>
            </div>

            <div class="p-2">
                <input class="form-control" type="text" name="contenu" placeholder="Contenu" required>
            </div>

            <div class="p-2">
                <input class="form-control" type="date" name="datetime" required>
            </div>

            <div class="p-2">
                <input class="form-control" type="text" name="category" placeholder="ex : science" required>
            </div>

            <div class="p-2">
                <button class="btn btn-primary w-100" type="submit">Créer</button>
            </div>
        </form>
    </section>

<?php
include 'include/footer.php';
?>
<?php
include 'include/header.php';

// Vérifier admin
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header("Location: 404.php");
    exit;
}

// Connexion DB
$mysqli = mysqli_connect("localhost", "root", "", "blog2");

// Vérifier l'ID
if (!isset($_GET['id'])) {
    die("Erreur : aucun ID envoyé");
}

$id = intval($_GET['id']);

// ⚠️ CHANGE LE NOM DE LA TABLE ICI ⚠️
$stmt = $mysqli->prepare("DELETE FROM post WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: posts.php?deleted=1");
    exit;
} else {
    echo "Erreur lors de la suppression : " . $stmt->error;
}

include 'include/footer.php';
?>


<?php
include 'include/footer.php';

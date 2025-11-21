<?php
include 'include/header.php';


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Connexion database
$con = mysqli_connect("localhost", "root", "", "blog2");

// Récupérer les données de l'utilisateur connecté
$email = $_SESSION['email'];

$sql = "SELECT id, username, email FROM user WHERE email = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body text-center p-4">

                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['username']) ?>&background=0D6EFD&color=fff&size=120"
                             class="rounded-circle mb-3 shadow">

                        <h3 class="fw-bold"><?= htmlspecialchars($user['username']) ?></h3>
                        <p class="text-muted mb-4"><?= htmlspecialchars($user['email']) ?></p>

                        <div class="text-start">
                            <p><strong>ID Utilisateur :</strong> <?= $user['id'] ?></p>
                        </div>

                        <a href="logout.php" class="btn btn-danger w-100 mt-3">Déconnexion</a>
                        <?php
                        if (!empty($_SESSION['role_id']) && $_SESSION['role_id'] == 3) {
                            echo '<a href="admin.php" class="btn btn-primary mt-3">Accès Admin</a>';
                        }
                        ?>

                    </div>
                </div>

            </div>
        </div>
    </div>

<?php
include 'include/footer.php';
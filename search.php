<?php
include 'include/header.php';
$con = mysqli_connect("localhost", "root", "", "blog2");

$cat = "";

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $cat = trim($_GET['q']);

    // Trouver la catégorie
    $stmt = $con->prepare("SELECT category_id FROM category WHERE name LIKE ?");
    $like = "%".$cat."%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $category_id = $row['category_id'];

        // Récupérer les posts liés
        $sql = "
        SELECT 
            post.id, 
            post.Titre, 
            post.contenu, 
            user.username,
            COALESCE(category.name, 'Pas de catégorie') AS categorie
        FROM post
        JOIN category_has_post ON post.id = category_has_post.post_id
        LEFT JOIN category ON category.category_id = category_has_post.category_id
        JOIN user ON user.id = post.user_id
        WHERE category_has_post.category_id = ?
        ";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $posts = $stmt->get_result();
    }
}
?>

<section id="search" class="d-flex justify-content-center bg-secondary-subtle p-3 mb-2 bg-secondary">
    <form method="GET" class="d-flex flex-column">

        <div class="p-2 text-white">
            <label for="site-search">Search the site:</label>
        </div>

        <div class="p-2">
            <input type="search" id="site-search" name="q" value="<?= htmlspecialchars($cat) ?>" />
        </div>

        <div class="p-2">
            <button type="submit" class="btn btn-danger w-100">Search</button>
        </div>

    </form>
</section>

<?php if (!empty($cat)) : ?>

    <div class="container py-4">
        <h2 class="mb-4 text-center">Résultats pour : <?= htmlspecialchars($cat) ?></h2>

        <div class="row g-4">

            <?php if (isset($posts) && $posts->num_rows > 0) : ?>
                <?php while ($p = $posts->fetch_assoc()) : ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card shadow-sm p-3">
                            <h5><?= htmlspecialchars($p['Titre']) ?></h5>
                            <p><?= htmlspecialchars($p['contenu']) ?></p>

                            <small>
                                <strong>Auteur :</strong> <?= htmlspecialchars($p['username']) ?><br>
                                <strong>Catégorie :</strong> <?= htmlspecialchars($p['categorie']) ?>
                            </small>
                        </div>
                    </div>
                <?php endwhile; ?>

            <?php else : ?>
                <h4 class="text-center text-danger">Aucun article trouvé.</h4>
            <?php endif; ?>

        </div>
    </div>

<?php endif; ?>

<?php include 'include/footer.php'; ?>

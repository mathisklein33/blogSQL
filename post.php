<?php
include 'include/header.php';

$con = mysqli_connect("localhost", "root", "", "blog2");

$sql = "
SELECT 
    post.id,
    post.Titre,
    post.contenu,
    post.datetime,
    user.username AS auteur,
    COALESCE(category.name, 'Pas de catégorie') AS categorie
FROM post
JOIN user ON user.id = post.user_id
LEFT JOIN category_has_post ON category_has_post.post_id = post.id
LEFT JOIN category ON category.category_id = category_has_post.category_id
ORDER BY post.id DESC
";

$result = mysqli_query($con, $sql);
?>

    <section id="search" class="d-flex justify-content-center bg-secondary-subtle p-3 mb-2 bg-secondary">
        <a class="p-3 btn btn-danger" href="search.php">chercher un post</a>
    </section>

    <section>
        <div class="container py-5">

            <h1 class="mb-4 text-center">Articles du blog</h1>

            <div class="row g-4">
                <?php while($row = mysqli_fetch_assoc($result)) : ?>

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card shadow-sm">

                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['Titre']) ?></h5>

                                <p class="card-text"><?= htmlspecialchars($row['contenu']) ?></p>

                                <p class="text-muted small mb-0">
                                    <strong>Auteur :</strong> <?= htmlspecialchars($row['auteur']) ?>
                                    <br>
                                    <strong>Date :</strong> <?= htmlspecialchars($row['datetime']) ?>
                                    <br>
                                    <strong>Catégorie :</strong> <?= htmlspecialchars($row['categorie']) ?>
                                </p>
                            </div>

                        </div>
                    </div>

                <?php endwhile; ?>
            </div>

        </div>
    </section>

<?php
include 'include/footer.php';
?>
<?php


$DB_DSN = 'mysql:host=127.0.0.1;dbname=blog;charset=utf8mb4';
$DB_USER = 'root';
$DB_PASS = '';
try {
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    var_dump('PDO CONNECTED', $pdo);
} catch (Throwable $error) {
    http_response_code(500);
    echo "ERREUR BDD : " . $error->getMessage();
    exit;
}
function selectAll(PDO $pdo, string $table)
{
    $sql = "SELECT * FROM $table";
    return $pdo->query($sql)->fetchAll();
}

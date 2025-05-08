<?php
include 'db.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>Error: No ID provided for deletion.</div>";
    exit();
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
    $stmt->execute([$id]);
    // Reorder the IDs
    $pdo->exec("SET @count = 0");
    $pdo->exec("UPDATE items SET id = (@count := @count + 1)");
    $pdo->exec("ALTER TABLE items AUTO_INCREMENT = 1");

    header("Location: index.php");
    exit();
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}
?>
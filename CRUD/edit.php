<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$item) {
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $skin_type = $_POST['skin_type'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    try {
        $stmt = $pdo->prepare("UPDATE items SET name = ?, brand = ?, skin_type = ?, price = ?, stock = ? WHERE id = ?");
        $stmt->execute([$name, $brand, $skin_type, $price, $stock, $id]);
        
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Skincare Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Edit Item</h1>
            <a href="index.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="<?= htmlspecialchars($item['brand']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="skin_type" class="form-label">Skin Type</label>
                        <select class="form-select" id="skin_type" name="skin_type">
                            <option value="All" <?= $item['skin_type'] == 'All' ? 'selected' : '' ?>>All Skin Types</option>
                            <option value="Dry" <?= $item['skin_type'] == 'Dry' ? 'selected' : '' ?>>Dry</option>
                            <option value="Oily" <?= $item['skin_type'] == 'Oily' ? 'selected' : '' ?>>Oily</option>
                            <option value="Combination" <?= $item['skin_type'] == 'Combination' ? 'selected' : '' ?>>Combination</option>
                            <option value="Sensitive" <?= $item['skin_type'] == 'Sensitive' ? 'selected' : '' ?>>Sensitive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price ($)</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?= htmlspecialchars($item['price']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="
                        <div class="mb-3">
    <label for="stock" class="form-label">Stock Quantity</label>
    <input type="number" class="form-control" id="stock" name="stock" min="0" value="<?= htmlspecialchars($item['stock']) ?>" required>
</div>
<button type="submit" class="btn btn-success">
    <i class="fas fa-save"></i> Update Item
</button>

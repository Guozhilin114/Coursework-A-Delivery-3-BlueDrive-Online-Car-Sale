<?php
session_start();

// 未登录卖家不能访问
if (!isset($_SESSION['seller_id'])) {
    header("Location: seller-login.php");
    exit;
}

require_once __DIR__ . '/includes/db.php';

$seller_id = $_SESSION['seller_id'];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 基础字段
    $brand        = trim($_POST['brand']);
    $model        = trim($_POST['model']);
    $year         = intval($_POST['year']);
    $mileage      = trim($_POST['mileage']);
    $fuel_type    = trim($_POST['fuel_type']);
    $transmission = trim($_POST['transmission']);
    $colour       = trim($_POST['colour']);
    $location     = trim($_POST['location']);
    $price        = floatval($_POST['price']);
    $description  = trim($_POST['description']);

    // 图片上传
    $image_path = '';
    if (!empty($_FILES['carImage']['tmp_name'])) {
        $uploadDir = __DIR__ . '/assets/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = uniqid() . '_' . basename($_FILES['carImage']['name']);
        $target   = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['carImage']['tmp_name'], $target)) {
            $image_path = 'assets/uploads/' . $filename;
        }
    }

    // 插入 cars 表（完全对齐 schema.sql）
    $sql = "INSERT INTO cars (
                seller_id, brand, model, year, mileage,
                fuel_type, transmission, colour,
                location, price, image_path, description
            ) VALUES (
                :seller_id, :brand, :model, :year, :mileage,
                :fuel_type, :transmission, :colour,
                :location, :price, :image_path, :description
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':seller_id'   => $seller_id,
        ':brand'       => $brand,
        ':model'       => $model,
        ':year'        => $year,
        ':mileage'     => $mileage,
        ':fuel_type'   => $fuel_type,
        ':transmission'=> $transmission,
        ':colour'      => $colour,
        ':location'    => $location,
        ':price'       => $price,
        ':image_path'  => $image_path,
        ':description' => $description
    ]);

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload Car</title>
<style>
    body { font-family:Arial; background:#f0f2f5; padding:20px; }
    .container { max-width:700px; margin:auto; background:#fff; padding:30px; border-radius:8px; }
    .form-group { margin-bottom:15px; }
    label { font-weight:bold; display:block; margin-bottom:5px; }
    input, select, textarea { width:100%; padding:10px; }
    .btn { background:#1a73e8; color:#fff; border:none; padding:12px; width:100%; cursor:pointer; }
    .success { background:#d4edda; padding:10px; text-align:center; margin-bottom:15px; }
</style>
</head>
<body>

<div class="container">
    <h2>Upload Your Car</h2>

    <?php if ($success): ?>
        <div class="success">
            Car uploaded successfully!
            <a href="search.php">Go to Search Page</a>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label>Brand</label>
            <input type="text" name="brand" required>
        </div>

        <div class="form-group">
            <label>Model</label>
            <input type="text" name="model" required>
        </div>

        <div class="form-group">
            <label>Year</label>
            <input type="number" name="year" required>
        </div>

        <div class="form-group">
            <label>Mileage</label>
            <input type="text" name="mileage" placeholder="e.g., 45,000 km">
        </div>

        <div class="form-group">
            <label>Fuel Type</label>
            <select name="fuel_type">
                <option>Petrol</option>
                <option>Diesel</option>
                <option>Electric</option>
                <option>Hybrid</option>
            </select>
        </div>

        <div class="form-group">
            <label>Transmission</label>
            <select name="transmission">
                <option>Automatic</option>
                <option>Manual</option>
            </select>
        </div>

        <div class="form-group">
            <label>Colour</label>
            <input type="text" name="colour">
        </div>

        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location">
        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description"></textarea>
        </div>

        <div class="form-group">
            <label>Car Image</label>
            <input type="file" name="carImage" accept="image/*" required>
        </div>

        <button class="btn" type="submit">Upload Car</button>
    </form>
</div>

</body>
</html>
<?php
session_start();
require_once __DIR__ . "/../includes/auth_check.php";
require_once __DIR__ . "/../includes/db.php";

if (!isset($_SESSION['seller_id'])) {
    header("Location: seller-login.php?error=login_required");
    exit;
}

$seller_id = $_SESSION['seller_id'];

$success = false;
$error_msg = '';
$last_inserted_model = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = trim($_POST['brand'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $year = intval($_POST['year'] ?? 0);
    $mileage = trim($_POST['mileage'] ?? '');
    $fuel_type = trim($_POST['fuel_type'] ?? '');
    $transmission = trim($_POST['transmission'] ?? '');
    $colour = trim($_POST['colour'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $description = trim($_POST['description'] ?? '');

    if ($brand === '' || $model === '') {
        $error_msg = "Brand and model are required.";
    } elseif ($year < 1900 || $year > 2026) {
        $error_msg = "Please enter a valid year.";
    } elseif ($price <= 0) {
        $error_msg = "Please enter a valid price.";
    }

    $image_path = '';

    if (empty($error_msg)) {
        if (isset($_FILES['carImage']) && $_FILES['carImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/car_images/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileExtension = strtolower(pathinfo($_FILES['carImage']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($fileExtension, $allowedExtensions)) {
                $error_msg = "Only JPG, JPEG, PNG and WEBP images are allowed.";
            } else {
                $filename = uniqid('car_') . '.' . $fileExtension;
                $target = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['carImage']['tmp_name'], $target)) {
                    $image_path = '../uploads/car_images/' . $filename;
                } else {
                    $error_msg = "Image upload failed. Please try again.";
                }
            }
        } else {
            $error_msg = "Please select a car image.";
        }
    }

    if (empty($error_msg)) {
        $sql = "INSERT INTO cars (
                    seller_id, brand, model, year, mileage,
                    fuel_type, transmission, colour,
                    location, price, image_path, description
                ) VALUES (
                    :seller_id, :brand, :model, :year, :mileage,
                    :fuel_type, :transmission, :colour,
                    :location, :price, :image_path, :description
                )";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':seller_id'    => $seller_id,
                ':brand'        => $brand,
                ':model'        => $model,
                ':year'         => $year,
                ':mileage'      => $mileage,
                ':fuel_type'    => $fuel_type,
                ':transmission' => $transmission,
                ':colour'       => $colour,
                ':location'     => $location,
                ':price'        => $price,
                ':image_path'   => $image_path,
                ':description'  => $description
            ]);

            $last_inserted_model = $model;
            $success = true;
        } catch (PDOException $e) {
            $error_msg = "Error saving data to database.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Your Car - Used Car Marketplace</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #f0f2f5; padding: 20px; }
        .container { max-width: 700px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-bottom: 25px; padding-bottom: 10px; border-bottom: 2px solid #eee; }
        .alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; text-align: center; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-info { background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        input, select, textarea { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; }
        input:focus, select:focus, textarea:focus { border-color: #1a73e8; outline: none; box-shadow: 0 0 0 2px rgba(26,115,232,0.2); }
        .submit-btn { background-color: #1a73e8; color: white; border: none; padding: 15px; width: 100%; border-radius: 4px; font-size: 18px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        .submit-btn:hover { background-color: #0d5bb5; }
        .action-links { margin-top: 15px; text-align: center; }
        .action-links a { color: #1a73e8; text-decoration: none; margin: 0 10px; }
        .action-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload Your Car to the Marketplace</h2>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-error">
                <strong>Error:</strong> <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <strong>Success!</strong> Your car "<strong><?php echo htmlspecialchars($last_inserted_model); ?></strong>" has been uploaded successfully.
                <div class="action-links">
                    <a href="search.php?model=<?php echo urlencode($last_inserted_model); ?>">🔍 View it in search results</a>
                    <a href="search.php">Browse all cars</a>
                    <a href="add-car.php">Upload another car</a>
                </div>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="brand">Brand *</label>
                <input type="text" id="brand" name="brand" placeholder="e.g., Toyota, Honda, BMW" required>
            </div>

            <div class="form-group">
                <label for="model">Model *</label>
                <input type="text" id="model" name="model" placeholder="e.g., Camry, Civic, 3 Series" required>
            </div>

            <div class="form-group">
                <label for="year">Manufacturing Year *</label>
                <input type="number" id="year" name="year" min="1900" max="2026" placeholder="e.g., 2020" required>
            </div>

            <div class="form-group">
                <label for="mileage">Mileage</label>
                <input type="text" id="mileage" name="mileage" placeholder="e.g., 45,000 km">
            </div>

            <div class="form-group">
                <label for="fuel_type">Fuel Type</label>
                <select id="fuel_type" name="fuel_type">
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Electric">Electric</option>
                    <option value="Hybrid">Hybrid</option>
                </select>
            </div>

            <div class="form-group">
                <label for="transmission">Transmission</label>
                <select id="transmission" name="transmission">
                    <option value="Automatic">Automatic</option>
                    <option value="Manual">Manual</option>
                </select>
            </div>

            <div class="form-group">
                <label for="colour">Colour</label>
                <input type="text" id="colour" name="colour" placeholder="e.g., Silver, Black, Blue">
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" placeholder="e.g., Lingshui, Haikou">
            </div>

            <div class="form-group">
                <label for="price">Price (USD) *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" placeholder="e.g., 15000.00" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Describe your car's condition, features, and any other important details..."></textarea>
            </div>

            <div class="form-group">
                <label for="carImage">Car Image *</label>
                <input type="file" id="carImage" name="carImage" accept="image/*" required>
                <p style="font-size: 14px; color: #666; margin-top:5px;">Please upload a clear photo of the car (JPEG, PNG, etc.).</p>
            </div>

            <button type="submit" class="submit-btn">🚗 Upload Car to Marketplace</button>
        </form>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; color: #777;">
            <p>After uploading, your car will be immediately listed on the <a href="search.php">Search Page</a> for all buyers to see.</p>
        </div>
    </div>
</body>
</html>

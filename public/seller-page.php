<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/db.php';

$sellerId = $_SESSION['seller_id'] ?? null;
$sellerName = $_SESSION['seller_name'] ?? 'Seller';
$sellerUsername = $_SESSION['seller_username'] ?? '';
$sellerEmail = $_SESSION['seller_email'] ?? '';

$seller = [
    'full_name' => $sellerName,
    'username' => $sellerUsername,
    'email' => $sellerEmail,
    'phone' => 'Not provided',
    'address' => 'Not provided'
];

$cars = [];
$totalCars = 0;

if ($sellerId) {
    try {
        $sellerStmt = $pdo->prepare(
            "SELECT full_name, username, email, phone, address
             FROM sellers
             WHERE seller_id = :seller_id
             LIMIT 1"
        );
        $sellerStmt->execute([':seller_id' => $sellerId]);
        $sellerData = $sellerStmt->fetch(PDO::FETCH_ASSOC);

        if ($sellerData) {
            $seller = $sellerData;
        }

        $countStmt = $pdo->prepare(
            "SELECT COUNT(*) AS total
             FROM cars
             WHERE seller_id = :seller_id"
        );
        $countStmt->execute([':seller_id' => $sellerId]);
        $countResult = $countStmt->fetch(PDO::FETCH_ASSOC);
        $totalCars = $countResult ? (int)$countResult['total'] : 0;

        $carStmt = $pdo->prepare(
            "SELECT car_id, brand, model, year, mileage, fuel_type, transmission,
                    colour, location, price, image_path, description
             FROM cars
             WHERE seller_id = :seller_id
             ORDER BY created_at DESC
             LIMIT 3"
        );
        $carStmt->execute([':seller_id' => $sellerId]);
        $cars = $carStmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $cars = [];
    }
}

$addCarLink = file_exists(__DIR__ . '/add-car.php') ? 'add-car.php' : 'upload.php';
$searchLink = file_exists(__DIR__ . '/search.php') ? 'search.php' : 'search.html';

function safeText($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function formatPrice($value) {
    if ($value === null || $value === '') {
        return 'Price not set';
    }

    return '$' . number_format((float)$value, 0);
}

function getImagePath($path) {
    if (!$path) {
        return '';
    }

    return $path;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller Page</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #eee;
            min-height: 100vh;
            padding: 20px;
            color: #111;
        }

        .page {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            border-radius: 12px;
            padding: 20px 28px;
            margin-bottom: 25px;
            box-shadow: 0 4px 10px #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: blue;
        }

        .nav-links {
            display: flex;
            gap: 22px;
            flex-wrap: wrap;
        }

        .nav-links a {
            color: blue;
            text-decoration: none;
            font-weight: bold;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 1.4fr 0.8fr;
            gap: 24px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 10px #ccc;
        }

        .profile-card {
            min-height: 320px;
        }

        .profile-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 25px;
        }

        .identity {
            display: flex;
            gap: 18px;
            align-items: center;
        }

        .avatar {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: blue;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: bold;
            flex-shrink: 0;
        }

        .seller-name {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .seller-username {
            color: #777;
            font-size: 16px;
        }

        .status-pill {
            background: #e8f0ff;
            color: #003c8f;
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
        }

        .intro {
            color: #555;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .stat-card {
            background: #f7f7f7;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .stat-card strong {
            display: block;
            font-size: 28px;
            margin-bottom: 8px;
            color: black;
        }

        .stat-card span {
            color: #777;
            font-size: 14px;
            line-height: 1.5;
        }

        .contact-card h3,
        .section-title h3 {
            font-size: 22px;
            margin-bottom: 18px;
        }

        .contact-list {
            display: grid;
            gap: 14px;
        }

        .contact-item {
            background: #f7f7f7;
            border-radius: 8px;
            padding: 14px;
            border: 1px solid #ddd;
        }

        .contact-item label {
            display: block;
            color: #777;
            font-size: 13px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .contact-item div {
            color: #111;
            font-weight: bold;
            line-height: 1.5;
            word-break: break-word;
        }

        .action-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-top: 20px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            font-size: 17px;
            font-weight: bold;
        }

        .btn-primary {
            background: blue;
            color: white;
        }

        .btn-primary:hover {
            background: darkblue;
        }

        .btn-secondary {
            background: #f2f2f2;
            color: blue;
            border: 1px solid #ccc;
        }

        .btn-secondary:hover {
            background: #e6e6e6;
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 18px;
        }

        .section-title p {
            color: #777;
            font-size: 15px;
        }

        .inventory-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .vehicle-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px #ccc;
        }

        .vehicle-image {
            height: 190px;
            background: #ddd;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .vehicle-tag {
            position: absolute;
            top: 12px;
            left: 12px;
            background: blue;
            color: white;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .vehicle-body {
            padding: 18px;
        }

        .vehicle-body h4 {
            font-size: 19px;
            margin-bottom: 10px;
        }

        .vehicle-meta {
            color: #777;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 14px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .price-row strong {
            font-size: 20px;
        }

        .mini-btn {
            color: blue;
            font-weight: bold;
            text-decoration: none;
        }

        .mini-btn:hover {
            text-decoration: underline;
        }

        .empty-state {
            background: white;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 4px 10px #ccc;
            text-align: center;
            color: #555;
        }

        .empty-state h3 {
            color: black;
            margin-bottom: 12px;
        }

        @media (max-width: 950px) {
            .main-grid {
                grid-template-columns: 1fr;
            }

            .inventory-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 650px) {
            body {
                padding: 12px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-links {
                gap: 14px;
            }

            .card {
                padding: 22px;
            }

            .profile-top {
                flex-direction: column;
            }

            .identity {
                flex-direction: column;
                align-items: flex-start;
            }

            .seller-name {
                font-size: 26px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .inventory-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<div class="page">

    <div class="header">
        <div class="logo">Blue Drive Car Market</div>
        <div class="nav-links">
            <a href="<?php echo safeText($searchLink); ?>">Browse Cars</a>
            <a href="<?php echo safeText($addCarLink); ?>">Add Car</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="main-grid">
        <section class="card profile-card">
            <div class="profile-top">
                <div class="identity">
                    <div class="avatar">
                        <?php echo strtoupper(substr($seller['full_name'] ?: 'S', 0, 1)); ?>
                    </div>

                    <div>
                        <h1 class="seller-name">Welcome, <?php echo safeText($seller['full_name']); ?></h1>
                        <p class="seller-username">
                            Seller account:
                            <?php echo safeText($seller['username'] ?: 'Not provided'); ?>
                        </p>
                    </div>
                </div>

                <div class="status-pill">Logged In Seller</div>
            </div>

            <p class="intro">
                This seller page shows your account information and your uploaded car listings.
                You can add a new car, review your current listings, or log out from your seller account.
            </p>

            <div class="stats">
                <div class="stat-card">
                    <strong><?php echo safeText($totalCars); ?></strong>
                    <span>Uploaded vehicles connected to this seller account.</span>
                </div>

                <div class="stat-card">
                    <strong>ID</strong>
                    <span>Seller ID: <?php echo safeText($sellerId); ?></span>
                </div>

                <div class="stat-card">
                    <strong>Active</strong>
                    <span>Current session is verified through seller login.</span>
                </div>
            </div>
        </section>

        <aside class="card contact-card">
            <h3>Seller Information</h3>

            <div class="contact-list">
                <div class="contact-item">
                    <label>Full Name</label>
                    <div><?php echo safeText($seller['full_name']); ?></div>
                </div>

                <div class="contact-item">
                    <label>Username</label>
                    <div><?php echo safeText($seller['username']); ?></div>
                </div>

                <div class="contact-item">
                    <label>Email</label>
                    <div><?php echo safeText($seller['email']); ?></div>
                </div>

                <div class="contact-item">
                    <label>Phone</label>
                    <div><?php echo safeText($seller['phone']); ?></div>
                </div>

                <div class="contact-item">
                    <label>Address</label>
                    <div><?php echo safeText($seller['address']); ?></div>
                </div>
            </div>

            <div class="action-row">
                <a class="btn btn-primary" href="<?php echo safeText($addCarLink); ?>">Add Car</a>
                <a class="btn btn-secondary" href="logout.php">Logout</a>
            </div>
        </aside>
    </div>

    <section>
        <div class="section-title">
            <div>
                <h3>Uploaded Vehicles</h3>
                <p>Recent cars uploaded by this seller account.</p>
            </div>
        </div>

        <?php if (!empty($cars)): ?>
            <div class="inventory-grid">
                <?php foreach ($cars as $car): ?>
                    <?php
                    $imagePath = getImagePath($car['image_path'] ?? '');
                    $carTitle = trim(($car['year'] ?? '') . ' ' . ($car['brand'] ?? '') . ' ' . ($car['model'] ?? ''));
                    $detailLink = 'car-detail.php?id=' . urlencode($car['car_id']);
                    ?>
                    <article class="vehicle-card">
                        <div class="vehicle-image"
                             style="<?php echo $imagePath ? "background-image: url('" . safeText($imagePath) . "');" : ''; ?>">
                            <div class="vehicle-tag"><?php echo safeText($car['fuel_type'] ?: 'Car Listing'); ?></div>
                        </div>

                        <div class="vehicle-body">
                            <h4><?php echo safeText($carTitle ?: 'Car Listing'); ?></h4>

                            <div class="vehicle-meta">
                                <?php echo safeText($car['mileage']); ?> mi ·
                                <?php echo safeText($car['transmission']); ?> ·
                                <?php echo safeText($car['location']); ?>
                            </div>

                            <div class="price-row">
                                <strong><?php echo safeText(formatPrice($car['price'])); ?></strong>
                                <a class="mini-btn" href="<?php echo safeText($detailLink); ?>">View Listing</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>No uploaded vehicles yet</h3>
                <p>You have not uploaded any cars with this seller account.</p>
                <br>
                <a class="btn btn-primary" href="<?php echo safeText($addCarLink); ?>">Add Your First Car</a>
            </div>
        <?php endif; ?>
    </section>

</div>

</body>
</html>

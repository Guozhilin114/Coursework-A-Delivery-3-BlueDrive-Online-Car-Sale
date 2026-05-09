<?php
require_once __DIR__ . "/../includes/db.php";

$car_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$car_id) {
    $car = null;
} else {
    $sql = "
        SELECT 
            cars.*,
            sellers.full_name,
            sellers.phone,
            sellers.email
        FROM cars
        LEFT JOIN sellers ON cars.seller_id = sellers.seller_id
        WHERE cars.car_id = ?
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$car_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
}

function h($value) {
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}

function displayPrice($price) {
    if ($price === null || $price === "") {
        return "Price not available";
    }
    return "$" . number_format((float)$price, 2);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details - Used Car Marketplace</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f0f2f5;
            padding: 20px;
        }
        
        .container {
            width: min(100% - 2rem, 1200px);
            max-width: 1000px;
            margin: 0 auto;
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: blue;
        }
        
        .nav-links a {
            color: blue;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
        }
        
        .nav-links a:hover {
            text-decoration: underline;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: blue;
            text-decoration: none;
        }
        
        .car-detail {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .car-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .car-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        
        .car-price {
            font-size: 24px;
            color: blue;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .car-specs {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .spec-item {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
        }
        
        .spec-label {
            font-weight: bold;
            color: #666;
            font-size: 14px;
        }
        
        .spec-value {
            font-size: 18px;
            color: #333;
            margin-top: 5px;
        }
        
        .car-description {
            margin-top: 30px;
        }
        
        .description-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        
        .description-text {
            line-height: 1.6;
            color: #666;
        }
        // redesign contact seller
        .contact-seller {
            margin-top: 40px;
            padding: 28px;
            background: linear-gradient(to bottom, #fafafa, #f5f5f5);
            border: 1px solid #e5e5e5;
            border-radius: 16px;
        }

        .contact-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .contact-title {
            font-size: 24px;
            font-weight: 700;
            color: #222;
            letter-spacing: -0.5px;
        }

        .contact-subtitle {
            color: #777;
            font-size: 15px;
            margin-top: 4px;
        }

        .seller-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .seller-card {
            background: white;
            padding: 18px;
            border-radius: 12px;
            border: 1px solid #ececec;
            transition: all 0.25s ease;
        }

        .seller-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        .seller-label {
            font-size: 13px;
            color: #888;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .seller-value {
            font-size: 18px;
            font-weight: 600;
            color: #222;
            word-break: break-word;
        }

        .contact-btn {
            background: #111;
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .contact-btn:hover {
            background: #333;
            transform: translateY(-1px);
        }


        .message-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .message-box h2 {
            margin-bottom: 15px;
            color: #333;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #777;
            font-size: 14px;
        }

        img, video, iframe {
            max-width: 100%;
            height: auto;
        }

        html {
            font-size: clamp(1rem, 0.75rem + 0.5vw, 1.25rem);
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">CarMarket</div>
            <div class="nav-links">
                <a href="seller-login.php">Seller Login</a>
                <a href="add-car.php">Upload Car</a>
                <a href="developers.php">Developers</a>
            </div>
        </header>
        
        <a href="search.php" class="back-link">← Back to Search</a>

        <?php if (!$car): ?>
            <div class="message-box">
                <h2>Car Not Found</h2>
                <p>The selected car does not exist or the car ID is invalid.</p>
                <br>
                <a href="search.php">Return to Search Page</a>
            </div>
        <?php else: ?>
            <div class="car-detail">
                <img 
                    src="<?= h($car['image_path']) ?>" 
                    alt="<?= h($car['brand'] . ' ' . $car['model']) ?>" 
                    class="car-image"
                >
                
                <h1 class="car-title">
                    <?= h($car['brand']) ?> <?= h($car['model']) ?> <?= h($car['year']) ?>
                </h1>

                <div class="car-price">
                    <?= displayPrice($car['price']) ?>
                </div>
                
                <div class="car-specs">
                    <div class="spec-item">
                        <div class="spec-label">Brand</div>
                        <div class="spec-value"><?= h($car['brand']) ?></div>
                    </div>

                    <div class="spec-item">
                        <div class="spec-label">Model</div>
                        <div class="spec-value"><?= h($car['model']) ?></div>
                    </div>

                    <div class="spec-item">
                        <div class="spec-label">Year</div>
                        <div class="spec-value"><?= h($car['year']) ?></div>
                    </div>

                    <div class="spec-item">
                        <div class="spec-label">Mileage</div>
                        <div class="spec-value"><?= h($car['mileage']) ?></div>
                    </div>

                    <div class="spec-item">
                        <div class="spec-label">Fuel Type</div>
                        <div class="spec-value"><?= h($car['fuel_type']) ?></div>
                    </div>

                    <div class="spec-item">
                        <div class="spec-label">Transmission</div>
                        <div class="spec-value"><?= h($car['transmission']) ?></div>
                    </div>

                    <div class="spec-item">
                        <div class="spec-label">Color</div>
                        <div class="spec-value"><?= h($car['colour']) ?></div>
                    </div>

                    <div class="spec-item">
                        <div class="spec-label">Location</div>
                        <div class="spec-value"><?= h($car['location']) ?></div>
                    </div>
                </div>
                
                <div class="car-description">
                    <h2 class="description-title">Description</h2>
                    <p class="description-text">
                        <?= nl2br(h($car['description'])) ?>
                    </p>
                </div>
                
                <div class="contact-seller">
                    <div class="contact-header">
                        <div>
                            <h2 class="contact-title">Contact Seller</h2>
                            <p class="contact-subtitle">
                                Reach out to the seller for more details or a test drive.
                            </p>
                        </div>

                        <button class="contact-btn" onclick="showContactMessage()">
                            Contact Seller
                        </button>
                    </div>

                    <div class="seller-info">

                        <div class="seller-card">
                            <div class="seller-label">Seller Name</div>
                            <div class="seller-value">
                                <?= h($car['full_name']) ?>
                            </div>
                        </div>

                        <div class="seller-card">
                            <div class="seller-label">Phone</div>
                            <div class="seller-value">
                                <?= h($car['phone']) ?>
                            </div>
                        </div>

                        <div class="seller-card">
                            <div class="seller-label">Email</div>
                            <div class="seller-value">
                                <?= h($car['email']) ?>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        <?php endif; ?>

        <footer>
            <p>&copy; 2026 BlueDrive Online Car Sale. All rights reserved.</p>
        </footer>
    </div>

    <script>
        function showContactMessage() {
            alert("Please contact the seller using the phone number or email shown above.");
        }
    </script>
</body>
</html>

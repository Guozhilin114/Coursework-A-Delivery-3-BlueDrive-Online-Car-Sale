<?php
require_once __DIR__ . "/../includes/db.php";

$model = isset($_GET['model']) ? trim($_GET['model']) : "";
$year = isset($_GET['year']) ? trim($_GET['year']) : "";

$sql = "SELECT car_id, brand, model, year, colour, location, price, image_path, description
        FROM cars
        WHERE 1=1";


$params = [];

if ($model !== "") {
    $sql .= " AND (brand LIKE :brand OR model LIKE :model)";
    $params[":brand"] = "%" . $model . "%";
    $params[":model"] = "%" . $model . "%";
}


if ($year !== "") {
    $sql .= " AND year = :year";
    $params[":year"] = $year;
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

function h($value) {
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Cars - Blue Drive Car Market</title>

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
            margin: 0 auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            color: #1a73e8;
            font-weight: bold;
        }

        .logo img {
            height: 36px;
        }

        .nav-links a {
            color: #1a73e8;
            text-decoration: none;
            margin-left: 25px;
            font-size: 18px;
            font-weight: 600;
            font-family: 'Segoe UI', Arial, sans-serif;
            padding: 5px 0;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: #0d5bb5;
            text-decoration: none;
        }

        .search-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 40px;
            border: 2px solid #e0e0e0;
        }

        .search-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .search-form {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 15px;
        }

        .search-form input {
            width: 100%;
            padding: 16px 18px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .search-form input:focus {
            outline: none;
            border-color: #1a73e8;
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.1);
        }

        .search-form button {
            background-color: #1a73e8;
            color: white;
            border: none;
            padding: 16px 25px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #0d5bb5;
        }

        .cars-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }

        .car-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.10);
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.13);
        }
        
        .car-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }
        
        .car-info {
            padding: 20px;
        }
        
        .car-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        
        .car-details {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .car-price {
            color: #1a73e8;
            font-weight: bold;
            font-size: 18px;
        }


        .no-results {
            text-align: center;
            padding: 50px 20px;
            color: #777;
            grid-column: 1 / -1;
            font-size: 18px;
            background: white;
            border-radius: 12px;
        }

        footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #777;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .search-form {
                grid-template-columns: 1fr;
            }

            .cars-container {
                grid-template-columns: 1fr;
            }

            header {
                flex-direction: column;
                gap: 15px;
            }

            .nav-links a {
                margin-left: 10px;
                margin-right: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="../assets/images/logo.png" alt="Blue DriveDrive">
                Blue Drive Car Market
            </div>

            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="seller-login.php">Seller Login</a>
                <a href="add-car.php">Upload Car</a>
                <a href="developers.php">Developers</a>
            </div>
        </header>

        <div class="search-box">
            <h1 class="search-title">Search Cars</h1>

            <form class="search-form" method="get" action="search.php">
                <input 
                    type="text" 
                    name="model" 
                    placeholder="Search by brand or model, e.g. Toyota, Camry, BMW"
                    value="<?php echo h($model); ?>"
                >

                <input 
                    type="number" 
                    name="year" 
                    placeholder="Year, e.g. 2020"
                    value="<?php echo h($year); ?>"
                >

                <button type="submit">Search</button>
            </form>
        </div>

        <div class="cars-container">
            <?php if (count($cars) === 0): ?>
                <div class="no-results">
                    No matching cars found. Try another model or year.
                </div>
            <?php else: ?>
                <?php foreach ($cars as $car): ?>
                    <?php
                        $image = $car['image_path'];
                        if ($image === "" || $image === null) {
                            $image = "../assets/images/default-car.jpg";
                        }
                    ?>

                    <a class="car-card" href="car-detail.php?id=<?php echo h($car['car_id']); ?>">
                        <img 
                            src="<?php echo h($image); ?>" 
                            alt="<?php echo h($car['brand'] . ' ' . $car['model']); ?>"
                            class="car-image"
                        >

                        <div class="car-info">
                            <h3 class="car-name">
                                <?php echo h($car['brand'] . ' ' . $car['model'] . ' ' . $car['year']); ?>
                            </h3>
                            
                            <p class="car-details">
                                <?php echo h("Registered " . $car['year'] . ", " . $car['colour'] . ", located in " . $car['location']); ?>
                            </p>
                            
                            <div class="car-price">
                                $<?php echo h(number_format((float)$car['price'], 2)); ?>
                            </div>
                        </div>

                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <footer>
            &copy; Blue Drive Car Market. All rights reserved.
        </footer>
    </div>
</body>
</html>

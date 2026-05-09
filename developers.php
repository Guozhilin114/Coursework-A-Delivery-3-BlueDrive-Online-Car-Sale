<?php
session_start();

$developers = [
    [
        "name" => "Zhu Tongchen",
        "student_id" => "250001572",
        "email" => "jp2024213885@qmul.ac.uk",
        "contribution" => "add-car.php, car insert, image upload, seller_id foreign key"
    ],
    [
        "name" => "Guo Zhilin",
        "student_id" => "250001642",
        "email" => "jp2024213866@qmul.ac.uk",
        "contribution" => "database structure, search.php, car-detail.php, final integration"
    ],
    [
        "name" => "Liu Jiasheng",
        "student_id" => "250001675",
        "email" => "jp2024213875@qmul.ac.uk",
        "contribution" => "index.php, register.php, seller registration"
    ],
    [
        "name" => "Zhang Chenye",
        "student_id" => "250001712",
        "email" => "jp2024213874@qmul.ac.uk",
        "contribution" => "seller-login.php, session handling, logout.php, developers.php"
    ]
];

function h($value) {
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Developer Information - BlueDrive</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        html {
            font-size: clamp(1rem, 0.75rem + 0.5vw, 1.25rem);
        }

        body {
            background-color: #eee;
            padding: 40px 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
        }

        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px #ccc;
        }

        .logo {
            width: 130px;
            height: auto;
        }

        .nav-links a {
            color: #0056d6;
            text-decoration: none;
            margin-left: 18px;
            font-size: 15px;
            font-weight: bold;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        h1 {
            color: black;
            text-align: center;
            margin-bottom: 30px;
            font-size: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px #ccc;
        }

        th, td {
            padding: 16px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #0056d6;
            color: white;
            font-weight: 600;
        }

        td {
            border-bottom: 1px solid #ccc;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .name {
            font-weight: bold;
            color: black;
        }

        .student-id {
            color: #777;
        }

        .email {
            color: #0056d6;
        }

        .workflow-box {
            margin-top: 30px;
            background: white;
            padding: 22px;
            border-radius: 8px;
            box-shadow: 0 4px 10px #ccc;
            line-height: 1.6;
        }

        .workflow-box h2 {
            margin-bottom: 10px;
            color: #222;
        }

        .back-link {
            color: #0056d6;
            text-decoration: none;
            display: inline-block;
            margin-top: 30px;
            text-align: center;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 700px) {
            .top-nav {
                flex-direction: column;
                gap: 15px;
            }

            .nav-links {
                text-align: center;
            }

            .nav-links a {
                display: inline-block;
                margin: 6px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="top-nav">
            <img src="../assets/images/logo.png" alt="BlueDrive Logo" class="logo">

            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="search.php">Search Cars</a>

                <?php if (isset($_SESSION["seller_id"])): ?>
                    <a href="seller-page.php">Seller Page</a>
                    <a href="add-car.php">Add Car</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="register.php">Register</a>
                    <a href="seller-login.php">Seller Login</a>
                <?php endif; ?>
            </div>
        </div>

        <h1>Developer Information</h1>

        <table>
            <tr>
                <th>Name</th>
                <th>Student ID</th>
                <th>Email</th>
                <th>Contribution</th>
            </tr>

            <?php foreach ($developers as $developer): ?>
                <tr>
                    <td class="name"><?= h($developer["name"]) ?></td>
                    <td class="student-id"><?= h($developer["student_id"]) ?></td>
                    <td class="email"><?= h($developer["email"]) ?></td>
                    <td><?= h($developer["contribution"]) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="workflow-box">
            <h2>GitHub Workflow</h2>
            <p>
                This project follows the required Delivery 3 GitHub workflow. The team uses
                a main branch, a develop branch, and individual feature branches. Each member
                works on their own upgraded PHP page and merges their work through pull requests.
            </p>
        </div>

        <a href="search.php" class="back-link">← Back to Car Marketplace</a>

    </div>
</body>
</html>

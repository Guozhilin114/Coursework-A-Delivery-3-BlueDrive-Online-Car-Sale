<?php
// db.php
$conn = new mysqli("localhost", "root", "", "online_car_sale");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

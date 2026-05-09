<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: seller-login.php");
    exit();
}

$login = trim($_POST['login'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($login === '' || $password === '') {
    header("Location: seller-login.php?error=empty");
    exit();
}

try {
    $stmt = $pdo->prepare(
        "SELECT seller_id, full_name, email, username, password
         FROM sellers
         WHERE username = :login OR email = :login
         LIMIT 1"
    );

    $stmt->execute([
        ':login' => $login
    ]);

    $seller = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$seller) {
        header("Location: seller-login.php?error=invalid");
        exit();
    }

    if (!password_verify($password, $seller['password'])) {
        header("Location: seller-login.php?error=invalid");
        exit();
    }

    session_regenerate_id(true);

    $_SESSION['seller_logged_in'] = true;
    $_SESSION['seller_id'] = $seller['seller_id'];
    $_SESSION['seller_username'] = $seller['username'];
    $_SESSION['seller_name'] = $seller['full_name'];
    $_SESSION['seller_email'] = $seller['email'];

    /*
    Version 3:
    Seller account is verified from the database.
    Seller session is created after successful login.
    Logout, auth_check, and final redirect will be added in the next version.
    */

    header("Location: seller-login.php?status=session_created");
    exit();

} catch (PDOException $e) {
    header("Location: seller-login.php?error=database");
    exit();
}
?>

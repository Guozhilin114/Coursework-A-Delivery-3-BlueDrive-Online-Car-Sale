<?php
require_once __DIR__ . '/includes/db.php';

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

    /*
    Version 2 note:
    The seller account is now checked from the database.
    Password verification uses password_verify() because register.php stores hashed passwords.
    Session handling and redirecting to the add-car/upload page will be added in Version 3.
    */

    header("Location: seller-login.php?status=verified");
    exit();

} catch (PDOException $e) {
    header("Location: seller-login.php?error=database");
    exit();
}
?>

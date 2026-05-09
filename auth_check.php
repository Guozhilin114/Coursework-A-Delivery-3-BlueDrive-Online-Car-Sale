<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['seller_logged_in']) || $_SESSION['seller_logged_in'] !== true) {
    header("Location: seller-login.php?error=login_required");
    exit();
}
?>

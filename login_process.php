<?php
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

/*
Version 1 note:
This file only receives login form data.
Database connection, seller verification, password checking,
session handling, and redirect to add-car/upload page
will be added in later versions.
*/

header("Location: seller-login.php?status=received");
exit();
?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['seller_logged_in']) && $_SESSION['seller_logged_in'] === true;
$sellerName = $_SESSION['seller_name'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Login</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

img, video, iframe {
    max-width: 100%;
    height: auto;
}

html {
    font-size: clamp(1rem, 0.75rem + 0.5vw, 1.25rem);
}

body {
    background: #eee;
    padding: 20px;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container {
    max-width: 500px;
    margin: 0 auto;
    width: 100%;
}

.header {
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 1px solid #ccc;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    color: blue;
    margin-bottom: 10px;
}

.nav-links a {
    color: blue;
    text-decoration: none;
    margin-left: 20px;
}

.back-link {
    display: inline-block;
    margin-bottom: 20px;
    color: blue;
    text-decoration: none;
}

h2 {
    color: black;
    margin-bottom: 20px;
    text-align: center;
    font-size: 28px;
}

.form-box {
    background: white;
    padding: 50px;
    border-radius: 12px;
    box-shadow: 0 4px 10px #ccc;
}

.form-inner {
    max-width: 400px;
    margin: 0 auto;
}

.form-item {
    margin-bottom: 30px;
}

.form-item label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    font-size: 16px;
}

input {
    border: 1px solid #ccc;
    padding: 16px;
    width: 100%;
    margin-top: 5px;
    border-radius: 6px;
    font-size: 16px;
}

input:focus {
    outline: none;
    border-color: blue;
}

button,
.action-link {
    background: blue;
    color: white;
    padding: 16px;
    border: none;
    border-radius: 6px;
    width: 100%;
    margin-top: 15px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    display: block;
    text-align: center;
    text-decoration: none;
}

button:hover,
.action-link:hover {
    background: darkblue;
}

.logout-link {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: blue;
    text-decoration: none;
    font-weight: bold;
}

.register-link {
    text-align: center;
    margin-top: 20px;
}

.message {
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
    text-align: center;
    font-weight: bold;
    font-size: 14px;
}

.message.error {
    background: #ffe6e6;
    color: #b00020;
}

.message.info {
    background: #e8f0ff;
    color: #003c8f;
}

.message.success {
    background: #e6ffe6;
    color: #116b11;
}

@media (max-width: 600px) {
    body {
        padding: 10px;
    }

    .header {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }

    .nav-links a {
        margin-left: 0;
        margin-right: 15px;
    }

    .form-box {
        padding: 30px 20px;
    }
}
</style>
</head>

<body>

<div class="container">

    <div class="header">
        <p class="logo">CarMarket</p>
        <div class="nav-links">
            <a href="search.php">Browse Cars</a>
            <a href="upload.php">Upload Car</a>
        </div>
    </div>

    <a href="search.php" class="back-link">← Back to Search</a>

    <h2>Seller Login</h2>

    <div class="form-box">
        <div class="form-inner">

            <?php if (isset($_GET['error']) && $_GET['error'] === 'empty'): ?>
                <div class="message error">Please fill in all fields.</div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
                <div class="message error">Invalid username/email or password.</div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'database'): ?>
                <div class="message error">Database error. Please try again later.</div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'login_required'): ?>
                <div class="message error">Please log in before accessing the seller page.</div>
            <?php endif; ?>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'logged_out'): ?>
                <div class="message info">You have logged out successfully.</div>
            <?php endif; ?>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'logged_in'): ?>
                <div class="message success">Login successful. Seller session has been created.</div>
            <?php endif; ?>

            <?php if ($isLoggedIn): ?>
                <div class="message success">
                    You are logged in as <?php echo htmlspecialchars($sellerName); ?>.
                </div>

                <?php if (file_exists(__DIR__ . '/add-car.php')): ?>
                    <a class="action-link" href="add-car.php">Go to Add Car Page</a>
                <?php elseif (file_exists(__DIR__ . '/upload.php')): ?>
                    <a class="action-link" href="upload.php">Go to Upload Car Page</a>
                <?php else: ?>
                    <div class="message info">Add Car / Upload page is not available yet.</div>
                <?php endif; ?>

                <a class="logout-link" href="logout.php">Logout</a>

            <?php else: ?>

                <form action="login_process.php" method="POST">
                    <div class="form-item">
                        <label>Username or Email *</label>
                        <input type="text" name="login" placeholder="Enter username or email" required>
                    </div>

                    <div class="form-item">
                        <label>Password *</label>
                        <input type="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <button type="submit">Login to Seller Account</button>

                    <div class="register-link">
                        <p>New seller? <a href="register.php">Register here</a></p>
                    </div>
                </form>

            <?php endif; ?>

        </div>
    </div>

</div>

</body>
</html>

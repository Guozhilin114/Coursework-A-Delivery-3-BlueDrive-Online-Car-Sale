<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    require_once __DIR__ . "/db.php";

    $full_name = trim($_POST["name"]);
    $address   = trim($_POST["address"]);
    $phone     = trim($_POST["phone"]);
    $email     = trim($_POST["email"]);
    $username  = trim($_POST["username"]);
    $password  = $_POST["password"];

    if (!preg_match("/^[A-Za-z\s]+$/", $full_name)) {
        $errors[] = "Invalid full name.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!preg_match("/^1[3-9]\d{9}$/", $phone)) {
        $errors[] = "Invalid Chinese phone number.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT seller_id FROM sellers WHERE username = ?");
            $stmt->execute([$username]);

            if ($stmt->rowCount() > 0) {
                $errors[] = "Username already exists.";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error occurred.";
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO sellers 
                 (full_name, address, phone, email, username, password)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );

            $stmt->execute([
                $full_name,
                $address,
                $phone,
                $email,
                $username,
                $hashedPassword
            ]);

            $success = true;
        } catch (PDOException $e) {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration - Used Car Marketplace</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /*Don't ask me what color you want. Search online by yourself and fill it in the color section.*/

        body {
            background-color: #f0f2f5;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Container matching login page */
        .container {
            max-width: 500px;
            width: 100%;
        }

        /* Header styles */
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
            color: #1a73e8;
        }

        .nav-links a {
            color: #1a73e8;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #0b64d8;
            text-decoration: none;
        }

        .register-form {
            background: white;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            margin: 0 auto;
        }

        .register-form h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 16px;
            color: #555;
        }

        .required {
            color: #ff4444;
        }

        input {
            width: 100%;
            padding: 16px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #1a73e8;
        }

        input.error {
            border-color: #ff4444;
        }

        .error-message {
            color: #ff4444;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .register-btn {
            background-color: #1a73e8;
            color: white;
            border: none;
            padding: 16px;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            transition: background-color 0.2s;
        }

        .register-btn:hover {
            background-color: #0d5bb5;
        }

        .register-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 15px;
        }

        .login-link a {
            color: #1a73e8;
            text-decoration: none;
            font-weight: bold;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #777;
            font-size: 14px;
        }

        .form-content {
            max-width: 400px;
            margin: 0 auto;
        }

        .password-hint {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Universal box-sizing for consistent element dimensions */
        * {
            box-sizing: border-box;
        }

        /* Ensure media elements scale responsively without overflow */
        img,
        video,
        iframe {
            max-width: 100%;
            height: auto;
        }

        /* Responsive container: full-width on mobile, centered with max-width on desktop */
        .container {
            width: min(100% - 2rem, 1200px);
            margin: 0 auto;
        }

        /* Fluid typography: scales font-size between mobile, tablet, and desktop */
        html {
            font-size: clamp(1rem, 0.75rem + 0.5vw, 1.25rem);
        }

        /* Adaptive grid: auto-adjusts columns based on available screen space */
        .responsive-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">CarMarket</div>
            <div class="nav-links">
                <a href="search.php">Browse Cars</a>
                <a href="upload.php">Upload Car</a>
            </div>
        </header>

        <a href="seller-login.php" class="back-link">← Back to Login</a>

        <div class="register-form">
            <h2>Seller Registration</h2>
            <div class="form-content">
                <form id="registerForm" method="POST" action="register.php">
                    <?php if (!empty($errors)) : ?>
                        <div style="color:red; margin-bottom:15px;">
                            <?php foreach ($errors as $err) : ?>
                                <p><?php echo htmlspecialchars($err); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success) : ?>
                        <div style="color:green; margin-bottom:15px;">
                            <p>Registration successful! You can now <a href="seller-login.html">login</a>.</p>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="name">Full Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                        <div class="error-message" id="name-error">Name must be at least 2 characters long</div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address <span class="required">*</span></label>
                        <input type="text" id="address" name="address" placeholder="Enter your address" required>
                        <div class="error-message" id="address-error">Address must be at least 5 characters long</div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Chinese Phone Number <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" placeholder="e.g. 13800138000" required>
                        <div class="error-message" id="phone-error">Please enter a valid Chinese phone number (11 digits
                            starting with 1)</div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" placeholder="your@email.com" required>
                        <div class="error-message" id="email-error">Please enter a valid email address</div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username <span class="required">*</span></label>
                        <input type="text" id="username" name="username" placeholder="Enter username" required>
                        <div class="error-message" id="username-error">Username must be 4-20 characters (letters,
                            numbers, underscore only)</div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password <span class="required">*</span></label>
                        <input type="password" id="password" name="password" placeholder="Enter password" required>
                        <div class="password-hint">Password must be at least 8 characters with letters and numbers</div>
                        <div class="error-message" id="password-error">Password must be at least 8 characters with
                            letters and numbers</div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password <span class="required">*</span></label>
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" required>
                        <div class="error-message" id="confirm-password-error">Passwords do not match</div>
                    </div>

                    <button type="submit" class="register-btn" id="submitBtn">Create Seller Account</button>

                    <div class="login-link">
                        <p>Already have an account? <a href="seller-login.php">Login here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simple form validation for seller registration
        // Using regular expressions (regex) for client-side check

        // Get form and button
        const form = document.getElementById("registerForm");
        const submitBtn = document.getElementById("submitBtn");

        // Disable submit button at start
        submitBtn.disabled = true;

        // When user types something
        form.addEventListener("input",
            function() {
                checkAllFields();
            });

        // Check all fields
        function checkAllFields() {

            let nameOK = false;
            let addressOK = false;
            let phoneOK = false;
            let emailOK = false;
            let usernameOK = false;
            let passwordOK = false;
            let confirmOK = false;

            // ===== Name: only letters and spaces =====
            let nameInput = document.getElementById("name").value;
            let nameRegex = /^[A-Za-z\s]+$/;

            if (nameRegex.test(nameInput)) {
                document.getElementById("name-error").style.display = "none";
                nameOK = true;
            } else {
                document.getElementById("name-error").style.display = "block";
                nameOK = false;
            }

            // ===== Address: letters, numbers and spaces =====
            let addressInput = document.getElementById("address").value;
            let addressRegex = /^[A-Za-z0-9\s]+$/;

            if (addressRegex.test(addressInput)) {
                document.getElementById("address-error").style.display = "none";
                addressOK = true;
            } else {
                document.getElementById("address-error").style.display = "block";
                addressOK = false;
            }

            // ===== Phone: Chinese mobile number =====
            let phoneInput = document.getElementById("phone").value;
            let phoneRegex = /^1[3-9]\d{9}$/;

            if (phoneRegex.test(phoneInput)) {
                document.getElementById("phone-error").style.display = "none";
                phoneOK = true;
            } else {
                document.getElementById("phone-error").style.display = "block";
                phoneOK = false;
            }

            // ===== Email: must end with .com or .cn, only one @ =====
            let emailInput = document.getElementById("email").value;
            let emailRegex = /^[^\s@]+@[^\s@]+\.(com|cn)$/;

            if (emailRegex.test(emailInput)) {
                document.getElementById("email-error").style.display = "none";
                emailOK = true;
            } else {
                document.getElementById("email-error").style.display = "block";
                emailOK = false;
            }

            // ===== Username: at least 6 letters or numbers =====
            let usernameInput = document.getElementById("username").value;
            let usernameRegex = /^[A-Za-z0-9]{6,}$/;

            if (usernameRegex.test(usernameInput)) {
                document.getElementById("username-error").style.display = "none";
                usernameOK = true;
            } else {
                document.getElementById("username-error").style.display = "block";
                usernameOK = false;
            }

            // ===== Password: at least 6 letters or numbers =====
            let passwordInput = document.getElementById("password").value;
            let passwordRegex = /^[A-Za-z0-9]{6,}$/;

            if (passwordRegex.test(passwordInput)) {
                document.getElementById("password-error").style.display = "none";
                passwordOK = true;
            } else {
                document.getElementById("password-error").style.display = "block";
                passwordOK = false;
            }

            // ===== Confirm password =====
            let confirmInput = document.getElementById("confirmPassword").value;

            if (confirmInput === passwordInput && confirmInput.length > 0) {
                document.getElementById("confirm-password-error").style.display = "none";
                confirmOK = true;
            } else {
                document.getElementById("confirm-password-error").style.display = "block";
                confirmOK = false;
            }

            // Enable or disable submit button
            if (nameOK && addressOK && phoneOK && emailOK && usernameOK && passwordOK && confirmOK) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }
    </script>
</body>

</html>

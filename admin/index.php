<?php
session_set_cookie_params([
    'httponly' => true,
    'secure' => false,
    'samesite' => 'Strict'
]);

session_start();

/* Redirect if already logged in */
if (
    isset($_SESSION['admin_logged_in']) &&
    $_SESSION['admin_logged_in'] === true
) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

/* Admin Credentials */
$stored_username = "admin";

/* Password: admin123 */
$stored_hash = '$2y$10$gNDmAGOztQNeeY2FTcwlP.vuCAN0XCocplmCv.lnthr1/BhpR33BS';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {

        $error = "Please fill in all fields.";

    } else {

        if (
            $username === $stored_username &&
            password_verify($password, $stored_hash)
        ) {

            session_regenerate_id(true);

            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $stored_username;
            $_SESSION['last_activity'] = time();

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>PWU QR Attendance Login</title>

<link rel="stylesheet" href="../css/css/index.css">
<link rel="icon" type="image/png" href="../../pictures/PWU LOGO.png">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="../JS/index.js" defer></script>

</head>

<body>

<div class="glass-card">

    <!-- QR SECTION -->
    <div class="qr-side">

        <div class="qr-wrapper">

            <div id="reader" style="width:250px;"></div>

            <div class="qr-label" id="scanBtn">
                <i class="fas fa-camera"></i>
                Scan QR
            </div>

        </div>

        <button class="stop-camera" id="stopCamera">
            Stop Camera
        </button>

    </div>

    <!-- LOGIN SECTION -->
    <div class="login-side">

        <div class="logo-center">
            <img class="logo"
            src="../../pictures/PWU LOGO.png"
            alt="PWU Logo">
        </div>

        <form method="POST">

            <div class="input-group">
                <label>Username</label>

                <i class="fas fa-user"></i>

                <input
                    type="text"
                    name="username"
                    placeholder="Enter username"
                    autocomplete="off"
                    required>
            </div>

            <div class="input-group">

                <label>Password</label>

                <i class="fas fa-lock"></i>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter password"
                    required>

            </div>

            <?php if(!empty($error)): ?>

                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>

            <button type="submit" class="login-btn">

                <i class="fas fa-arrow-right-to-bracket"></i>

                LOGIN

            </button>

        </form>

    </div>

</div>

</body>
</html>
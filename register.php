<?php
// filepath: /BookBox/BookBox/public/register.php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || strlen($username) < 3) {
        $error = "Username must be at least 3 characters long.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $password)) {
        $error = "Password must be at least 6 characters and contain both letters and numbers.";
    } else {
        // Register user (note: this is NOT secure—see note below)
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="uploads/bookbox.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BookBox</title>
    <style>
        .floating-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .floating-logo {
            position: absolute;
            width: 90px;
            height: 90px;
            opacity: 0.8;
            filter: drop-shadow(0 6px 18px rgba(74,144,226,0.16));
            animation: floatLogo 24s cubic-bezier(.4,.8,.4,1) infinite;
            will-change: transform;
            transition: opacity 0.5s, filter 0.5s;
        }
        @keyframes floatLogo {
            0% { transform: translateY(0) scale(1) rotate(0deg); }
            25% { transform: translateY(-30px) scale(1.12) rotate(8deg); }
            50% { transform: translateY(-60px) scale(1.18) rotate(16deg); }
            75% { transform: translateY(-30px) scale(1.12) rotate(8deg); }
            100% { transform: translateY(0) scale(1) rotate(0deg); }
        }
        .welcome {
            font-size: 2.8rem;
            font-weight: 800;
            text-align: center;
            color: #4A90E2;
            margin-bottom: 10px;
            letter-spacing: 1.5px;
            background: linear-gradient(90deg, #4A90E2, #357ABD, #50D3C2);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: welcomeFade 2.2s cubic-bezier(.6,.1,.3,1) forwards;
            opacity: 0;
        }
        @keyframes welcomeFade {
            0% { opacity: 0; transform: scale(0.7) translateY(-40px); }
            60% { opacity: 1; transform: scale(1.08) translateY(8px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }
        .container {
            position: relative;
            z-index: 2;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            width: 100%;
            background-color: #4A90E2;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #357ABD;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="floating-bg">
        <img src="uploads/php_PNG7.png" class="floating-logo" style="top:10%;left:8%;animation-delay:0s;" />
        <img src="uploads/logo-javascript-logo-png-transparent.png" class="floating-logo" style="top:60%;left:12%;animation-delay:2s;" />
        <img src="uploads/sql.jpg" class="floating-logo" style="top:30%;left:80%;animation-delay:4s;" />
        <img src="uploads/kotlin.png" class="floating-logo" style="top:75%;left:70%;animation-delay:6s;" />
        <img src="uploads/Java-Logo.jpg" class="floating-logo" style="top:20%;left:60%;animation-delay:8s;" />
        <img src="uploads/typescript.jpg" class="floating-logo" style="top:50%;left:50%;animation-delay:10s;" />
        <img src="uploads/SWIFT.png" class="floating-logo" style="top:80%;left:30%;animation-delay:12s;" />
        <img src="uploads/clang.webp" class="floating-logo" style="top:40%;left:20%;animation-delay:14s;" />
    </div>
    <div class="container">
        <div class="welcome">Welcome to BookBox</div>
        <h1>Register</h1>
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Username (required, min 3 chars):</label>
                <input type="text" id="username" name="username" required minlength="3"/>
            </div>
            <div class="form-group">
                <label for="email">Email (required, must be valid):</label>
                <input type="email" id="email" name="email" required/>
            </div>
            <div class="form-group">
                <label for="password">Password (required, numbers and characters):</label>
                <input type="password" id="password" name="password" required/>
            </div>
            <button type="submit">Submit</button>
            <?php if (isset($_SESSION['user']) || isset($_SESSION['id'])): ?>
                <div style="margin-top:16px;text-align:center;color:#357ABD;font-weight:600;">
                    Already a user? <a href="login.php" style="color:#4A90E2;text-decoration:underline;font-weight:600;">Login here</a>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script>
    // Animate logos with smooth floating paths
    document.querySelectorAll('.floating-logo').forEach(function(logo, i) {
        var delay = logo.style.animationDelay || (i*2 + 's');
        logo.style.animationDelay = delay;
        var baseTop = parseInt(logo.style.top);
        var baseLeft = parseInt(logo.style.left);
        function animateLogo() {
            var now = Date.now();
            var t = baseTop + Math.sin(now/1800 + i*2) * 18;
            var l = baseLeft + Math.cos(now/2200 + i*2) * 16;
            logo.style.top = t + '%';
            logo.style.left = l + '%';
            requestAnimationFrame(animateLogo);
        }
        animateLogo();
    });
    </script>
</body>
</html>

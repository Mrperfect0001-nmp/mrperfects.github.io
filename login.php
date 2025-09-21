<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepared statement (prevents SQL injection)
    $sql = "SELECT user_id, email,password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Verify hashed password
        if ($password === $row["password"]) {
            $_SESSION["id"] = $row["user_id"];
            $_SESSION["email"] = $row["email"];
            header("Location: index.php");
            exit;
        } else {
            $error ="Invalid email or password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="uploads/bookbox.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - BookBox</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f9; display:flex; justify-content:center; align-items:center; height:100vh; margin:0;">

  <div style="background:#fff; padding:30px; border-radius:12px; box-shadow:0px 4px 12px rgba(0,0,0,0.1); width:350px; text-align:center;">
    <h1 style="margin-bottom:20px; color:#333;">Login to BookBox</h1>

    <?php if (isset($error)): ?>
      <div style="background:#ffdddd; color:#a33; padding:10px; border-radius:6px; margin-bottom:15px;">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php" style="text-align:left;">
      <label for="email" style="display:block; margin-bottom:5px; font-weight:bold;">Email:</label>
      <input type="email" id="email" name="email" required
        style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px;">

      <label for="password" style="display:block; margin-bottom:5px; font-weight:bold;">Password:</label>
      <input type="password" id="password" name="password" required
        style="width:100%; padding:10px; margin-bottom:20px; border:1px solid #ccc; border-radius:6px;">

      <button type="submit"
        style="width:100%; padding:12px; background:#4CAF50; color:#fff; font-size:16px; border:none; border-radius:6px; cursor:pointer;">
        Login
      </button>
    </form>

    <p style="margin-top:15px; font-size:14px;">Don't have an account? 
      <a href="register.php" style="color:#6a0dad; font-weight:bold; text-decoration:none;">Register here</a>.
    </p>
  </div>

</body>
</html>

<?php
session_start();
require_once 'core/dbConfig.php'; // Ensure this includes your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Fetch the user from the database
  $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username");
  $stmt->execute(['username' => $username]);
  $user = $stmt->fetch();

  // Check if user exists and verify password
  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    header('Location: index.php'); // Redirect to homepage
    exit;
  } else {
    $error = "Invalid username or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .btn_container {
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <h2>Login</h2>
    <form action="login.php" method="POST">
      <label for="username">Username:</label>
      <input type="text" name="username" required>
      <label for="password">Password:</label>
      <input type="password" name="password" required>
      <div class="btn_container">
        <button type="submit" class="btn">Login</button>
      </div>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </div>
</body>

</html>
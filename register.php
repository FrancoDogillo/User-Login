<?php
session_start();
require_once 'core/dbConfig.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // Insert user into the database
  $stmt = $pdo->prepare("INSERT INTO Users (username, password, added_by) VALUES (:username, :password, :added_by)");
  if ($stmt->execute(['username' => $username, 'password' => $password, 'added_by' => 'system'])) {
    header('Location: login.php'); // Redirect to login page after registration
    exit;
  } else {
    $error = "Registration failed. Username may already exist.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .btn_container {
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <h2>Register</h2>
    <form action="register.php" method="POST">
      <label for="username">Username:</label>
      <input type="text" name="username" required>
      <label for="password">Password:</label>
      <input type="password" name="password" required>
      <div class="btn_container">
        <button type="submit" class="btn">Register</button>
      </div>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>

</body>

</html>
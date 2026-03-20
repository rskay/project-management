<?php
// login.php
session_start();

function loginUser($username, $password) {
    // Placeholder for login logic
    // Validate credentials against database
    // Set session variables
    echo "Login attempt for: $username";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    loginUser($username, $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
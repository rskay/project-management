<?php
// register.php

function registerUser($username, $password, $role) {
    // Placeholder for user registration logic
    // Validate and hash the password
    // Save user to the database with selected role
    echo "User registered: $username with role $role";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    registerUser($username, $password, $role);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h1>Register</h1>
    <form method="POST" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <label for="role">Role:</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select>
        <br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
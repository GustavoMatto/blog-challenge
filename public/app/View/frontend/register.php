<?php

use Desafiobis2bis\App\Model\User;

$db = require_once __DIR__ . '/../Model/Config/db.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User($db);
    $user->createUser($username, $password);

    header("Location: login");
    exit();
} else {
    echo "Campos 'username' e 'password' não estão definidos.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">login
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<form method="post" action="register">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Register</button>
</form>

</body>
</html>

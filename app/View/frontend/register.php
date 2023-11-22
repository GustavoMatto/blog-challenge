<?php

use Desafiobis2bis\App\Model\Repository\UserRepository;
use Desafiobis2bis\App\Model\Config\Database;
use Desafiobis2bis\App\Acl\Acl;

session_start();

$loggedIn = false;
$db = new Database();

if (isset($_SESSION['user'])) {
    $loggedIn = true;

    $acl = new Acl();
    $userRepository = new UserRepository($db);

    $userId = $userRepository->getUserIdByUsername($_SESSION['user']);
    $user = $userRepository->loadUserData($userId);
    $hasPermission = $acl->hasPermission($user);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userRepository = new UserRepository(new Database());
    $userRepository->registerUser($username, $password);

    header("Location: login");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        /* Adicione estilos personalizados aqui, se necessário */
    </style>
</head>
<body>

<!-- Cabeçalho (Header) -->
<header class="bg-light p-3 text-center">
    <img src="caminho/para/seu/logo.png" alt="Seu Logo" height="50">
</header>

<!-- Barra de Navegação Bootstrap -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/sobre">About Us</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <?php
            if (!$loggedIn) {
                echo 
                    '<li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Log in</a>
                    </li>';
            }
            if (!empty($hasPermission)) {
                echo 
                    '<li class="nav-item">
                        <a class="nav-link" href="/adminPage">Administração</a>
                    </li>';
            }
            ?>
        </ul>
        <ul class="navbar-nav">
            <?php
            if ($loggedIn) {
                echo 
                    '<li class="nav-item">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/post">Post</a>
                    </li>';
            }
            ?>
        </ul>
    </div>
</nav>

<div class="container mt-3">
    <h1>Register</h1>

    <form method="post" action="">
        <div class="register-form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" required style="width: 500px;">

            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" required style="width: 500px;">
        </div>
        <button type="submit" class="btn" name="action" value="register">Register</button>
    </form>
</div>

<!-- Rodapé (Footer) -->
<footer class="bg-light p-3 text-center">
    <p>&copy; 2023 Seu Nome | <a href="#">Política de Privacidade</a></p>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>

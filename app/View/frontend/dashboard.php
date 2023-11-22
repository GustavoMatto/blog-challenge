<?php

session_start();

use Desafiobis2bis\App\Model\Repository\UserRepository;
use Desafiobis2bis\App\Model\Config\Database;
use Desafiobis2bis\App\Acl\Acl;

$loggedIn = false;

$db = new Database();

if (isset($_SESSION['user'])) {
    $loggedIn = true;

    $acl = new Acl();
    $userRepository = new UserRepository($db);

    $userId = $userRepository->getUserIdByUsername($_SESSION['user']);
    $user = $userRepository->loadUserData($userId);
    $hasPermission = $acl->hasPermission($user);
} else {
    $loggedIn = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                        <a class="nav-link" href="/post">Post</a>
                    </li>';
            }
            ?>
        </ul>
    </div>
</nav>

<!-- Conteúdo Principal -->
<div class="container mt-3">
    <h1>Bem-vindo à sua Dashboard!</h1>

    <!-- Adicione aqui o conteúdo específico da página de dashboard -->

    <div>
        <a href="account"><button>Minha Conta</button></a>
        <a href="logout"><button>Logout</button></a>
    </div>

</div>

<!-- Rodapé (Footer) -->
<footer class="bg-light p-3 text-center">
    <p>&copy; <?php echo date("Y"); ?> Seu Nome | <a href="#">Política de Privacidade</a></p>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>

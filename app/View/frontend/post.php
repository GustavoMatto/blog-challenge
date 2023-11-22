<?php

use Desafiobis2bis\App\Model\Repository\PostRepository;
use Desafiobis2bis\App\Model\Repository\UserRepository;
use Desafiobis2bis\App\Model\Config\Database;
use Desafiobis2bis\App\Acl\Acl;

session_start();

$loggedIn = false;
$db = new Database();
$postRepository = new PostRepository($db);

if (isset($_SESSION['user'])) {
    $loggedIn = true;

    $acl = new Acl();
    $userRepository = new UserRepository($db);

    $userId = $userRepository->getUserIdByUsername($_SESSION['user']);
    $user = $userRepository->loadUserData($userId);
    $hasPermission = $acl->hasPermission($user);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['postTitle']) && isset($_POST['postContent'])) {
        $postTitle = $_POST['postTitle'];
        $postContent = $_POST['postContent'];

        $postRepository->registerPost($postContent, $postTitle);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
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

<!-- Conteúdo Principal -->
<div class="container mt-3">
    <!-- Formulário para enviar um novo post -->
    <?php if ($loggedIn): ?>
        <form method="post">
            <label for="postTitle">Título do Post:</label>
            <input type="text" name="postTitle" class="form-control" required>
            <br>
            <label for="postContent">Conteúdo do Post:</label>
            <textarea name="postContent" rows="4" class="form-control" required></textarea>
            <br>
            <button type="submit" class="btn btn-primary">Postar</button>
        </form>
    <?php endif; ?>
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

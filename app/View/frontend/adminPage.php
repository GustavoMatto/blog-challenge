<?php

use Desafiobis2bis\App\Model\Repository\UserRepository;
use Desafiobis2bis\App\Model\Config\Database;
use Desafiobis2bis\App\Acl\Acl;

session_start();

$loggedIn = false;
$acl = new Acl();
$db = new Database();
$userRepository = new UserRepository($db);

if (isset($_SESSION['user'])) {
    $loggedIn = true;

    $userId = $userRepository->getUserIdByUsername($_SESSION['user']);
    $user = $userRepository->loadUserData($userId); 
    
    if (!$acl->hasPermission($user)) {
        header("Location: /login");
        exit();
    }
} else {
    header("Location: /login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generateDump'])) {
    $success = $db->generateDatabaseDump();
    if ($success) {
        echo '<div class="alert alert-success" role="alert">Dump do banco de dados gerado com sucesso!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Erro ao gerar o dump do banco de dados.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
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
            <li class="nav-item">
                <a class="nav-link" href="/adminPage">Administração</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/adminUserPage">Gerenciamento de Usuários</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/adminPostPage">Gerenciamento de Posts</a>
            </li>
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
    <form method="post" action="" class="generate-dump-form">
        <input type="hidden" name="generateDump" value="1">
        <button type="submit" class="btn btn-primary" name="generateDump">Gerar Dump do Banco de Dados</button>
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

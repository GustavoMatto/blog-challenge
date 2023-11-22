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

$db = new Database();
$userRepository = new UserRepository($db);
$allUsers = $userRepository->getAllUsers();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteUser'])) {
        $userRepository->deleteUserById($_POST['userId']);
        header("Location: /adminUserPage");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateUser'])) {
    $newUsername = $_POST['newUsername'];
    
    $userRepository->updateUsername($_POST['userId'], $_POST['newUsername']);
    header("Location: /adminUserPage");
        exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setDefault'])) {
    $defaultUser = 'Default';
    
    $userRepository->updateRole($_POST['userId'], $defaultUser);
    header("Location: /adminUserPage");
        exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setAdmin'])) {
    $adminUser = 'admin';
    
    $userRepository->updateRole($_POST['userId'], $adminUser);
    header("Location: /adminUserPage");
        exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Post Page</title>
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

<!-- Conteúdo Principal -->
<div class="container mt-3">
    <?php foreach ($allUsers as $user): ?>
        <div class="mt-3">
            <h3><?= $user['username']; ?></h3>
            <!-- Formulário de Edição -->
            <form method="post" action="" class="edit-user-form">
                <div class="form-group">
                    <label for="editUsername">Novo Usuário:</label>
                    <input type="text" class="form-control" id="editUsername" name="newUsername">
                </div>
                <input type="hidden" name="userId" value="<?= $user['id']; ?>">
                <button type="submit" class="btn btn-primary" name="updateUser">Atualizar</button>
                <button type="submit" class="btn btn-secondary" name="setDefault" value="1">Definir como Default</button>
                <button type="submit" class="btn btn-dark" name="setAdmin" value="1">Definir como Admin</button>
            </form>

            <!-- Formulário de Exclusão -->
            <form method="post" action="" class="delete-user-form">
                <input type="hidden" name="userId" value="<?= $user['id']; ?>">
                <button type="submit" class="btn btn-danger" name="deleteUser">Excluir</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<!-- Rodapé (Footer) -->
<footer class="bg-light p-3 text-center">
    <p>&copy; 2023 Seu Nome | <a href="#">Política de Privacidade</a></p>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
    // Adiciona confirmação para formulário de edição
    document.querySelectorAll('.edit-user-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!confirm('Tem certeza que deseja atualizar este Usuário?')) {
                event.preventDefault();
            }
        });
    });

    // Adiciona confirmação para formulário de exclusão
    document.querySelectorAll('.delete-user-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!confirm('Tem certeza que deseja excluir este Usuário?')) {
                event.preventDefault();
            }
        });
    });
</script>

</body>
</html>

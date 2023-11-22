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
    header("Location: /login");
    exit();
}

$userRepository = new UserRepository(new Database());

$_SESSION['id'] = $userRepository->getUserIdByUsername($_SESSION['user']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteUser'])) {
        $userRepository->deleteUser($_SESSION['user']);
        session_destroy();
        header("Location: /login");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateUsername'])) {
    $newUsername = $_POST['newUsername'];
    
    $userRepository->updateUsername($_SESSION['id'], $newUsername);
    $_SESSION['user'] = $newUsername;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
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
    <h1>Account</h1>

    <!-- Adicione aqui o conteúdo específico da página "Minha Conta" -->
    <form method="post" action="" id="updateUserForm">
        <div class="username-form-group">
            <label for="username">Username:</label>
            <input type="username" class="form-control" id="username" name="newUsername" style="width: 500px;" value="<?php echo $_SESSION['user']; ?>" >
        </div>
        <input type="hidden" name="updateUsername" value="1">
        <button type="submit" class="btn btn-success" name="updateUsername">Salvar</button>
    </form>
    <form method="post" action="" id="deleteUserForm">
        <input type="hidden" name="deleteUser" value="1">
        <button type="submit" class="btn btn-danger" id="btnDeleteUser">Excluir Usuário</button>
    </form>
</div>

<!-- Rodapé (Footer) -->
<footer class="bg-light p-3 text-center">
    <p>&copy; <?php echo date("Y"); ?> Seu Nome | <a href="#">Política de Privacidade</a></p>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
    document.getElementById('updateUserForm').addEventListener('submit', function(event) {
        if (!confirm('Tem certeza que deseja atualizar seu usuário?')) {
            event.preventDefault();
        }
    });

    document.getElementById('deleteUserForm').addEventListener('submit', function(event) {
        if (!confirm('Tem certeza que deseja excluir o usuário?')) {
            event.preventDefault();
        }
    });
</script>

</body>
</html>

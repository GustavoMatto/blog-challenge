<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Desafiobis2bis\App\Model\User;

$db = require_once __DIR__ . '/../Model/Config/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User($db);
    $authenticated = $user->authenticate($username, $password);

    if ($authenticated) {
        $_SESSION['user'] = $username;
        header("Location: dashboard");
    } else {
        $error = 'Usuário incorreto, ou inexistente';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/post">Post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/sobre">Sobre Nós</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Conteúdo Principal -->
<div class="container mt-3">
    <h1>Login</h1>
    
    <!-- Adicione os campos de usuário e senha -->
    <form method="post" action="">
        <div class="form-group">
            <label for="username">Usuário:</label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Senha:</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Log in</button>
    </form>

    <!-- Exibir mensagem de erro, se houver -->
    <?php if (isset($error)): ?>
        <p class="text-danger"><?php echo $error; ?></p>
    <?php endif; ?>

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
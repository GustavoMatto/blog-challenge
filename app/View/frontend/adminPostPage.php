<?php

use Desafiobis2bis\App\Model\Repository\PostRepository;
use Desafiobis2bis\App\Model\Repository\UserRepository;
use Desafiobis2bis\App\Model\Config\Database;
use Desafiobis2bis\App\Acl\Acl;

session_start();

$loggedIn = false;
$acl = new Acl();
$db = new Database();
$userRepository = new UserRepository($db);
$postRepository = new PostRepository($db);
$posts = $postRepository->getAllPosts();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deletePost'])) {
        $postRepository->deletePost($_POST['postId']);
        header("Location: /adminPostPage");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updatePost'])) {
    $newTitle = $_POST['newTitle'];
    $newContent = $_POST['newContent'];
    
    $postRepository->updatePost($_POST['postId'], $_POST['newTitle'], $_POST['newContent']);
    header("Location: /adminPostPage");
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
    <?php foreach ($posts as $post): ?>
        <div class="mt-3">
            <h3><?= $post['title']; ?></h3>
            <p><?= $post['content']; ?></p>
            <!-- Formulário de Edição -->
            <form method="post" action="" class="edit-post-form">
                <div class="form-group">
                    <label for="editTitle">Novo Título:</label>
                    <input type="text" class="form-control" id="editTitle" name="newTitle" required>
                </div>
                <div class="form-group">
                    <label for="editContent">Novo Conteúdo:</label>
                    <textarea class="form-control" id="editContent" name="newContent" required></textarea>
                </div>
                <input type="hidden" name="postId" value="<?= $post['id']; ?>">
                <button type="submit" class="btn btn-primary" name="updatePost">Atualizar</button>
            </form>

            <!-- Formulário de Exclusão -->
            <form method="post" action="" class="delete-post-form">
                <input type="hidden" name="postId" value="<?= $post['id']; ?>">
                <button type="submit" class="btn btn-danger" name="deletePost">Excluir</button>
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
    document.querySelectorAll('.edit-post-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!confirm('Tem certeza que deseja atualizar este post?')) {
                event.preventDefault();
            }
        });
    });

    // Adiciona confirmação para formulário de exclusão
    document.querySelectorAll('.delete-post-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!confirm('Tem certeza que deseja excluir este post?')) {
                event.preventDefault();
            }
        });
    });
</script>

</body>
</html>

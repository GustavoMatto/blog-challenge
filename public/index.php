<?php
$servername = "db";
$username = "admin";
$password = "root";
$dbname = "desafiobis2bis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão ao MySQL: " . $conn->connect_error);
} else {
    echo "Conexão ao MySQL bem-sucedida!";
}

$conn->close();

phpinfo();

?>
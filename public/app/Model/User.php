<?php

namespace Desafiobis2bis\App\Model;

use Desafiobis2bis\App\Model\Config\Database;

class User
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllUsers()
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createUser($username, $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            die("Erro ao criar usuário: " . $e->getMessage());
        }
    }

    public function updateUser($id, $username, $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET username = :username, password = :password WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            return $stmt->execute();
        } catch (\PDOException $e) {
            die("Erro ao atualizar usuário: " . $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (\PDOException $e) {
            die("Erro ao excluir usuário: " . $e->getMessage());
        }
    }

    public function authenticate($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        } else {
            return false;
        }
    }
}

<?php

namespace Desafiobis2bis\App\Model\Repository;

use Desafiobis2bis\App\Model\Repository\UserRepositoryInterface;
use Desafiobis2bis\App\Model\UserInterface;
use Desafiobis2bis\App\Model\User;
use Desafiobis2bis\App\Model\Config\Database;

class UserRepository implements UserRepositoryInterface
{
    protected Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function authenticate($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $parameters = [':username' => $username];

        $user = $this->db->executeStatement($sql, $parameters)->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }

        return false;
    }

    public function getAllUsers(): array
    {
        $sql = "SELECT * FROM users";
        return $this->db->executeStatement($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function registerUser($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $parameters = [':username' => $username, ':password' => $hashedPassword];

        return $this->db->executeStatement($sql, $parameters);
    }

    public function updateUsername($id, $username)
    {
        $sql = "UPDATE users SET username = :username WHERE id = :id";
        $parameters = [':id' => $id, ':username' => $username];

        return $this->db->executeStatement($sql, $parameters);
    }

    public function updateRole($id, $role)
    {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $parameters = [':id' => $id, ':role' => $role];

        return $this->db->executeStatement($sql, $parameters);
    }

    public function deleteUser($username)
    {
        $sql = "DELETE FROM users WHERE username = :username";
        $parameters = [':username' => $username];

        return $this->db->executeStatement($sql, $parameters);
    }

    public function deleteUserById($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $parameters = [':id' => $id];

        return $this->db->executeStatement($sql, $parameters);
    }

    public function getUserIdByUsername($username)
    {
        $sql = "SELECT id FROM users WHERE username = :username";
        $parameters = [':username' => $username];

        return (int)$this->db->executeStatement($sql, $parameters)->fetchColumn();
    }

    public function loadUserData($userId): UserInterface
    {
        try {
            $db = $this->db->connection();

            $sql = "SELECT * FROM users WHERE id = :id";
            $parameters = [':id' => $userId];

            $userData = $this->db->executeStatement($sql, $parameters)->fetch(\PDO::FETCH_ASSOC);

            $user = new User($this->db, $userData['id']);
            $user->setUserId($userData['id']);
            $user->setUserName($userData['username']);
            $user->setRole($userData['role']);

            return $user;
        } catch (\PDOException $e) {
            die("Erro ao carregar dados do usuário: " . $e->getMessage());
        }
    }
}

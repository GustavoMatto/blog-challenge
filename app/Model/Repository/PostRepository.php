<?php

namespace Desafiobis2bis\App\Model\Repository;

use Desafiobis2bis\App\Model\Repository\PostRepositoryInterface;
use Desafiobis2bis\App\Model\Config\Database;

class PostRepository implements PostRepositoryInterface
{
    protected Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllPosts()
    {
        try {
            $db = $this->db->connection();

            $stmt = $db->prepare("SELECT * FROM posts");
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            die("Erro ao obter posts: " . $e->getMessage());
        }
    }

    public function registerPost($postContent, $postTitle)
    {
        try {
            $db = $this->db->connection();

            $stmt = $db->prepare("INSERT INTO posts (content, title) VALUES (:content, :title)");
            $stmt->bindParam(':content', $postContent);
            $stmt->bindParam(':title', $postTitle);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            die("Erro ao criar usuário: " . $e->getMessage());
        }
    }

    public function updatePost($id, $title, $content)
    {
        try {
            $db = $this->db->connection();

            $stmt = $db->prepare("UPDATE posts SET content = :content, title = :title WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':title', $title);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            die("Erro ao atualizar usuário: " . $e->getMessage());
        }
    }

    public function deletePost($id)
    {
        try {
            $db = $this->db->connection();

            $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            die("Erro ao excluir usuário: " . $e->getMessage());
        }
    }
}

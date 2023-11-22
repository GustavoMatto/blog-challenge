<?php

namespace Desafiobis2bis\App\Model;

use Desafiobis2bis\App\Model\UserInterface;
use Desafiobis2bis\App\Model\Config\Database;

class User implements UserInterface
{
    protected Database $db;
    protected $userId;

    public function __construct(Database $db, $userId)
    {
        $this->db = $db;
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getUserName()
    {
        return $this->db->getPropertyFromDatabase('username');
    }

    public function getRole()
    {
        return $this->db->getPropertyFromDatabase($this->userId, 'role');
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setUserName($newUsername)
    {
        $this->db->setPropertyInDatabase($this->userId, 'username', $newUsername);
    }

    public function setRole($newRole)
    {
        $this->db->setPropertyInDatabase($this->userId, 'role', $newRole);
    }
}
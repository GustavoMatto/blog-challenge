<?php

namespace Desafiobis2bis\App\Model\Repository;

use Desafiobis2bis\App\Model\UserInterface;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function registerUser($username, $password);
    public function updateUsername($id, $username);
    public function deleteUserById($id);
    public function loadUserData($userId): UserInterface;
}
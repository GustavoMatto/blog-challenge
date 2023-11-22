<?php

namespace Desafiobis2bis\App\Model;

interface UserInterface
{
    public function getUserId();
    public function getUserName();
    public function getRole();
    public function setUserId($userId);
    public function setUserName($newUsername);
    public function setRole($newRole);
}
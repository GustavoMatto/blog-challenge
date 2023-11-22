<?php

namespace Desafiobis2bis\App\Acl;

use Desafiobis2bis\App\Model\UserInterface;

interface AclInterface 
{
    const ADMIN = 'admin';
    public function hasPermission(UserInterface $user): bool;
}
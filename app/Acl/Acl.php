<?php

namespace Desafiobis2bis\App\Acl;

use Desafiobis2bis\App\Acl\AclInterface;
use Desafiobis2bis\App\Model\UserInterface;

class Acl implements AclInterface 
{
    public function hasPermission(UserInterface $user): bool 
    {
        $userRoles = $user->getRole();
        if (self::ADMIN === $userRoles) {
            return true;
        }
        return false;
    }
}
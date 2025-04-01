<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

class UserServices{

    public function __construct(private Security $security){
    }

    public function isSuperAdmin(){
        return $this->security->isGranted('SUPER_ROLE_ADMIN');
    }

    public function getConnectedUser(){
        return $this->security->getUser();
    }

    public function isTheConnectedUser(User $user){
        $currentUser = $this->security->getUser();
    
        if (!$currentUser instanceof User) {
            return false; // Nécessaire pour trantyper UserInterface en User
        }
    
        return $user->getIdUser() === $currentUser->getIdUser();
    }
    
}

?>
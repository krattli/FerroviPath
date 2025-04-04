<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserServices{

    public function __construct(private Security $security, private EntityManagerInterface $entityManager, private UserPasswordHasherInterface $userPasswordHasher){
    }

    public function isSuperAdmin(): bool // Vérification si c'est un admnistrateur
    {
        return $this->security->isGranted('ROLE_SUPER_ADMIN');
    }

    public function getConnectedUser(): ?User // Récupère l'utilisateur connecté
    {
        return $this->security->getUser();
    }

    public function isTheConnectedUser(User $user): bool // Vérifie si l'utilisateur est connecté ou non
    {
        $currentUser = $this->security->getUser();
    
        if (!$currentUser instanceof User) {
            return false; // Nécessaire pour trantyper UserInterface en User
        }
    
        return $user->getIdUser() === $currentUser->getIdUser();
    }
    
    public function modifyProfil($id,$oldPassword,$newPassword):bool // Fonction qui modifie le profil d'un utilisateur donné avec son nouveau et ancien mot de passe
    {
        if(!$this->userPasswordHasher->isPasswordValid($id, $oldPassword)){
            return false;
        }
        if(!empty($newPassword)){
            $id->setPassword($this->userPasswordHasher->hashPassword($id, $newPassword));
        }
        $this->entityManager->flush();
        return true;
    }

    public function modifyProfilWithoutConfirmation (User $id, string $plainPassword):void // Fonction qui modifier le profil d'un utilisateur donné sans nécessité de l'ancien de mot de passe
    {
        $id->setPassword($this->userPasswordHasher->hashPassword($id, $plainPassword));
        $this->entityManager->flush();
    }

    public function registerUser(User $user, string $plainPassword):bool // Fonction qui créer un nouveau utilisateur
    {
        // encode the plain password
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $plainPassword));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
       return true;
    }

    public function deleteUser(User $user):void // Fonction qui supprime un utilisateur
    {
        $user->setDeletedAt(new \DateTimeImmutable());
        $this->entityManager->flush();
    }

}

?>
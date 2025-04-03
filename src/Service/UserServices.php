<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Form\UserRoleType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Twig\Environment;

class UserServices
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $userPasswordHasher,
        private Environment $twig,
        private FormFactoryInterface $formFactory
    ) {}

    public function isSuperAdmin(): bool
    {
        return $this->security->isGranted('ROLE_SUPER_ADMIN');
    }

    public function getConnectedUser(): ?User
    {
        return $this->security->getUser();
    }

    public function isTheConnectedUser(User $user): bool
    {
        $currentUser = $this->security->getUser();

        if (!$currentUser instanceof User) {
            return false;
        }

        return $user->getIdUser() === $currentUser->getIdUser();
    }

    public function modifyProfil(User $user, string $oldPassword, string $newPassword): bool
    {
        if (!$this->userPasswordHasher->isPasswordValid($user, $oldPassword)) {
            return false;
        }
        if (!empty($newPassword)) {
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $newPassword));
        }
        $this->entityManager->flush();
        return true;
    }

    public function modifyProfilWithoutConfirmation(User $user, string $plainPassword): void
    {
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $plainPassword));
        $this->entityManager->flush();
    }

    public function registerUser(User $user, string $plainPassword): bool
    {
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $plainPassword));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return true;
    }

    public function deleteUser(User $user): void
    {
        $user->setDeletedAt(new \DateTimeImmutable());
        $this->entityManager->flush();
    }

    public function handleProfil(User $user): Response
    {
        if ($this->isTheConnectedUser($user) || $this->isSuperAdmin()) {
            return new Response($this->twig->render('user/profil.html.twig', ['profil' => $user]));
        }
        throw new AccessDeniedException('Vous n\'avez pas accès à cette page');
    }

    public function handleModify(Request $request, User $user): Response
    {
        if (!$this->isTheConnectedUser($user) && !$this->isSuperAdmin()) {
            throw new AccessDeniedException('Vous n\'avez pas accès à cette page');
        }

        $isSuperAdmin = $this->isSuperAdmin();
        $form = $this->createForm(UserType::class, $user, ['is_edit' => true, 'is_super_admin' => $isSuperAdmin]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($isSuperAdmin) {
                $this->modifyProfilWithoutConfirmation($user, $form->get('plainPassword')->getData());
                return new Response($this->twig->render('user/modify.html.twig', [
                    'modifyForm' => $form->createView(),
                    'profil' => $user,
                    'successMessage' => 'Le profil de ' . $user->getPseudo() . ' a été modifié !'
                ]));
            } elseif ($this->isTheConnectedUser($user)) {
                $answer = $this->modifyProfil($user, $form->get('oldPassword')->getData(), $form->get('plainPassword')->getData());
                if (!$answer) {
                    return new Response($this->twig->render('user/modify.html.twig', [
                        'modifyForm' => $form->createView(),
                        'profil' => $user,
                        'wrongPasswordMessage' => 'Ancien mot de passe incorrect, veuillez réessayer'
                    ]));
                }
            }
            return new Response($this->twig->render('user/modify.html.twig', [
                'modifyForm' => $form->createView(),
                'profil' => $user,
                'successMessage' => 'Modification du profil réussi !'
            ]));
        }

        return new Response($this->twig->render('user/modify.html.twig', [
            'modifyForm' => $form->createView(),
            'profil' => $user
        ]));
    }

    public function handleDelete(User $user): Response
    {
        if (!$this->isTheConnectedUser($user) && !$this->isSuperAdmin()) {
            throw new AccessDeniedException('Vous ne pouvez pas supprimer le compte d\'une autre personne');
        }

        $this->deleteUser($user);
        return new Response($this->twig->render('user/delete.html.twig', [
            'successMessage' => 'Suppression du compte réussi !'
        ]));
    }

    public function handleRegister(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->registerUser($user, $form->get('plainPassword')->getData());
            return new Response($this->twig->render('user/register.html.twig', [
                'registrationForm' => $form->createView(),
                'successMessage' => 'Vous êtes inscrit avec succès !'
            ]));
        }

        return new Response($this->twig->render('user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]));
    }

    public function handleEditRoles(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isSuperAdmin()) {
            throw new AccessDeniedException('Vous n\'avez pas accès à cette page');
        }

        $form = $this->createForm(UserRoleType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            return new Response($this->twig->render('user/role.html.twig', [
                'rolesForm' => $form->createView(),
                'user' => $user,
                'successMessage' => 'Rôles mis à jour avec succès.'
            ]));
        }

        return new Response($this->twig->render('user/role.html.twig', [
            'rolesForm' => $form->createView(),
            'user' => $user
        ]));
    }

    private function createForm(string $formType, $data, array $options = []): \Symfony\Component\Form\FormInterface
    {
        return $this->formFactory->create($formType, $data, $options);
    }
}

?>
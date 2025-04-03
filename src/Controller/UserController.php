<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserRoleType;
use App\Repository\UserRepository;
use App\Service\UserServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

    /*
     * J'ai externalisé la logique de toutes les routes dans la Classe UserServices
     * Mais comme je connais pas tout le détail des fonctionnalités User je peux pas dire si tout fonctionne comme prévu
     * J'ai testé un peu mais je garantis rien
     * Signé : Raphael
     */
final class UserController extends AbstractController
{
    public function __construct(private UserServices $userServices) {}

    #[Route('/user/{id}/profil', name: 'ferrovipath_user_profil', methods: ['GET'])]
    public function profil(User $user): Response
    {
        return $this->userServices->handleProfil($user);
    }

    #[Route('/user/{id}/modify', name: 'ferrovipath_user_modify', methods: ['GET', 'POST'])]
    public function modify(Request $request, User $user): Response
    {
        return $this->userServices->handleModify($request, $user);
    }

    #[Route('/user/{id}/delete', name: 'ferrovipath_user_delete', methods: ['GET'])]
    public function delete(User $user): Response
    {
        return $this->userServices->handleDelete($user);
    }

    #[Route('/user/register', name: 'ferrovipath_register')]
    public function register(Request $request): Response
    {
        return $this->userServices->handleRegister($request);
    }

    #[Route(path: '/user/login', name: 'ferrovipath_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('user/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route(path: '/user/logout', name: 'ferrovipath_logout')]
    public function logout(): void {}

    #[Route('/user/logout/success', name: 'ferrovipath_logout_success')]
    public function logoutSuccess(): Response
    {
        $this->addFlash('success', 'Déconnexion réussie !');
        return $this->redirectToRoute('ferrovipath_homepage');
    }

    #[Route('/admin/user/{id}/roles', name: 'admin_user_roles')]
    public function editRoles(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->userServices->handleEditRoles($request, $user, $entityManager);
    }
}

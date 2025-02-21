<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserRegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class UserController extends AbstractController{
    #[Route('/user', name: 'ferrovipath_user', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/profil/{id}', name: 'ferrovipath_user_profil', methods: ['GET'])]
    public function profil(User $user): Response
    {
        /*
        $profils = $this->getProfils();
        $profil = array_filter($profils, fn($profil) => $profil['id'] === $id);
        */
        if (empty($user)) {
            return $this->json(['message' => 'Profil not found'], 404);
        }
        return $this->render('user/profil.html.twig',  ['profil' => $user]);
    }

    /*public function getProfils(): array
    {
        return [
            [
            'id' => 1,
            'pseudo' => 'toto',
            'birth' => '01/12/2000',
            'email' => 'toto@gmail.com',
            'password' => 'TOTO',
            'createdAt' => '16/02/2025'
            ],
            [
            'id' => 2,
            'pseudo' => 'tata',
            'birth' => '02/12/2002',
            'email' => 'tata@gmail.com',
            'password' => 'TATA',
            'createdAt' => '16/02/2025'
            ],
            [
            'id' => 3,
            'pseudo' => 'tuto',
            'birth' => '21/12/2000',
            'email' => 'tuto@gmail.com',
            'password' => 'TUTO',
            'createdAt' => '16/02/2025']
        ];
    }*/

    #[Route('/user/modify/{id}', name: 'ferrovipath_user_modify', methods: ['GET', 'POST'])]
    public function modify(Request $request, User $id, EntityManagerInterface $entityManager): Response //update
    {
        /*$profils = $this->getProfils();
        $profil = array_filter($profils, fn($profil) => $profil['id'] === $id);*/
        
        $form = $this->createForm(UserType::class,$id);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('ferrovipath_user_profil');
        }

        return $this->render('user/modify.html.twig', [
            'form' => $form->createView(), 'profil' => $id
        ]);
    }
    
    #[Route('/register', name: 'app_register')] // Create
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success','Inscription réussie ! Bienvenue à Ferrovipath'); // Ajout d'un message flash qui s'affichera à la page d'accueil après l'inscription
            return $this->redirectToRoute('ferrovipath_homepage');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
    
    #[Route(path: '/login', name: 'app_login')] 
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    
}

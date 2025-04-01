<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class UserController extends AbstractController{

    public function __construct(private UserServices $user_services)
    {
        
    }

    #[Route('/user/{id}/profil', name: 'ferrovipath_user_profil', methods: ['GET'])]
    public function profil(User $user): Response
    {        
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        if($this->user_services->isTheConnectedUser($user) || $this->user_services->isSuperAdmin()){
            return $this->render('user/profil.html.twig',  ['profil' => $user]);
        }
        else{
            $this->addFlash("Vous n'avez pas accès à ce profil","error");
            return $this->redirectToRoute('ferrovipath_homepage');
        }
    }

    #[Route('/user/{id}/modify', name: 'ferrovipath_user_modify', methods: ['GET', 'POST'])]
    public function modify(Request $request, User $id, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response //update
    {     
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');   
        $form = $this->createForm(UserType::class, $id, ['is_edit' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $oldPassword = $form->get('oldPassword')->getData();
            // encode the plain password
            if(!$userPasswordHasher->isPasswordValid($id, $oldPassword)){
                return $this->render('user/modify.html.twig', [
                    'modifyForm' => $form->createView(), 'profil' => $id , 'wrongPasswordMessage'=>'Ancien mot de passe incorrecte, veuillez réessayer'
                ]);
            }
            $plainPassword = $form->get('plainPassword')->getData();
            if(!empty($plainPassword)){
                $id->setPassword($userPasswordHasher->hashPassword($id, $plainPassword));
            }
            $entityManager->flush();
            
            $this->addFlash('successModify','Modification du profil réussi !');
            return $this->redirectToRoute('ferrovipath_user_profil', ['id' => $id->getIdUser()]);
        }

        return $this->render('user/modify.html.twig', [
            'modifyForm' => $form->createView(), 'profil' => $id
        ]);
    }

    #[Route('/user/{id}/delete', name: 'ferrovipath_user_delete', methods: ['GET'])]
    public function delete(User $user, EntityManagerInterface $entityManager): Response //delete
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        // Hard delete
        $entityManager->remove($user);

        //$user->setDeletedAt(new \DateTimeImmutable());
        $entityManager->flush();

        return $this->redirectToRoute('ferrovipath_logout'); 
    }

    #[Route('/user/register', name: 'ferrovipath_register')] // Create
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            if(strtolower($form->get('email')->getData()) == 'admin@admin.com'){
                $user->addRole('ROLE_ADMIN');
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Vous êtes inscrit avec succès !');
            return $this->redirectToRoute('ferrovipath_homepage');
        }

        return $this->render('user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);

    }
    
    #[Route(path: '/user/login', name: 'ferrovipath_login')] 
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $this->addFlash('success', 'Connexion réussie !');
        return $this->render('user/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/user/logout', name: 'ferrovipath_logout')]
    public function logout(): void
    {
    }
    
    #[Route('/user/logout/success', name: 'ferrovipath_logout_success')]
    public function logoutSuccess(): Response
    {
        $this->addFlash('success', 'Déconnexion réussie !');
        return $this->redirectToRoute('ferrovipath_homepage');
    }

}

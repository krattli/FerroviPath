<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
            $this->addFlash("errorAccess", "Vous n'avez pas accès à cette page");
            return $this->redirectToRoute('ferrovipath_homepage');
        }
    }

    #[Route('/user/{id}/modify', name: 'ferrovipath_user_modify', methods: ['GET', 'POST'])]
    public function modify(Request $request, User $id): Response //update
    {     
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');   
    
        if(!($this->user_services->isTheConnectedUser($id) || $this->user_services->isSuperAdmin())){
            $this->addFlash("errorAccess", "Vous n'avez pas accès à cette page");
            return $this->redirectToRoute('ferrovipath_homepage');
        }
        $form = $this->createForm(UserType::class, $id, ['is_edit' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $answer = $this->user_services->modifyProfil($id,$form->get('oldPassword')->getData(),$form->get('plainPassword')->getData());
            if($answer==false){
                return $this->render('user/modify.html.twig', [
                    'modifyForm' => $form->createView(), 'profil' => $id , 'wrongPasswordMessage'=>'Ancien mot de passe incorrecte, veuillez réessayer'
                ]);
            }   
            $this->addFlash('success','Modification du profil réussi !');
            return $this->redirectToRoute('ferrovipath_user_profil', ['id' => $id->getIdUser()]);
        }

        return $this->render('user/modify.html.twig', [
            'modifyForm' => $form->createView(), 'profil' => $id
        ]);
    }
    
    #[Route('/user/{id}/delete', name: 'ferrovipath_user_delete', methods: ['GET'])]
    public function delete(User $user): Response //delete
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        /*// Hard delete
        $entityManager->remove($user);*/
        if(!($this->user_services->isTheConnectedUser($user) || $this->user_services->isSuperAdmin())){
            $this->addFlash("Vous ne pouvez pas supprimer le compte d'une autre personne","errorAccess");
            return $this->redirectToRoute('ferrovipath_homepage');
        }
        $this->user_services->deleteUser($user);
        $this->addFlash("success","Suppression du compte réussi !");
        return $this->redirectToRoute('ferrovipath_homepage');
    }

    #[Route('/user/register', name: 'ferrovipath_register')] // Create
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->user_services->registerUser($user, $form->get('plainPassword')->getData());
            $this->addFlash('success', 'Vous êtes inscrit avec succès !');
            return $this->redirectToRoute('ferrovipath_login');
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

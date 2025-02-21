<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController{
    #[Route('/user', name: 'ferrovipath_user', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/profil/{id}', name: 'ferrovipath_user_profil', methods: ['GET'])]
    public function profil(int $id): Response
    {
        $profils = $this->getProfils();
        $profil = array_filter($profils, fn($profil) => $profil['id'] === $id);

        if (empty($profil)) {
            return $this->json(['message' => 'Profil not found'], 404);
        }
        return $this->render('user/profil.html.twig',  ['profil' => array_values($profil)[0]]); //, ['user' => array_values($profil)[0]])
    }

    public function getProfils(): array
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
    }

    #[Route('/user/modify/{id}', name: 'ferrovipath_user_modify', methods: ['GET'])]
    public function modify(Request $request, int $id): Response
    {
        $profils = $this->getProfils();
        $profil = array_filter($profils, fn($profil) => $profil['id'] === $id);
        
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            return $this->redirectToRoute('ferrovipath_user_profil');
        }

        return $this->render('user/modify.html.twig', [
            'form' => $form->createView(), 'profil' => array_values($profil)[0]
        ]);
    }
}

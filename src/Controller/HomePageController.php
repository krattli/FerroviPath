<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'ferrovipath_homepage', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // Cette session sert seulement pour afficher le message de connexion car au moment de l'inscription, le login
        // est fait automatiquement par Symfony, donc ça été un peu bidouillé.
        $session = $request->getSession();
        if ($session->has('successConnexion')) {
            $this->addFlash('success', $session->get('successConnexion'));
            $session->remove('successConnexion'); // Supprime le message après l'affichage
        }
        //Cette session sert seulement à afficher le message d'erreur de permisisons lorsqu'on accède à une page dont on a pas les permissions
        if ($session->has('errorAccess')) {
            $this->addFlash('errorAccess', $session->get('errorAccess'));
            $session->remove('errorAccess'); // Supprime le message après l'affichage
        }


        return $this->render('homepage.html.twig');
    }
}

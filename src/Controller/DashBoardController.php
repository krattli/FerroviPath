<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashBoardController extends AbstractController
{
    public function __construct(private UserRepository $userRepository)
    {
        
    }

    #[Route('/dashboard', name: 'ferrovipath_admin_dashboard')]
    public function index(): Response
    {
        return $this->render('dash_board/index.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }
}

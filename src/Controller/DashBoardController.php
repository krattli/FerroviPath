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

    #[Route('/admin/dashboard', name: 'ferrovipath_admin_dashboard')]
    public function index(): Response
    {
        return $this->render('dash_board/dashboard.html.twig', [
            'users' => $this->userRepository->findAll(),
            'rolesForm' => null
        ]);
    }
}

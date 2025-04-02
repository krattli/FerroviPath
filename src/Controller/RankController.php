<?php

/*namespace App\Controller;

use App\Entity\User; //ajouté
use App\Entity\Game;//ajouté

use Doctrine\ORM\EntityManagerInterface; //ajouté
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
//
final class RankController extends AbstractController
{
    #[Route('/rank', name: 'ferrovipath_rank', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('rank/index.html.twig', [
            'controller_name' => 'RankController',
        ]);

    }
}
//


final class RankController extends AbstractController
{
    #[Route('/rank', name: 'ferrovipath_rank', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $query = $entityManager->createQuery(
            'SELECT u.idUser, u.pseudo, SUM(g.scorePoints) as totalScore
            FROM App\Entity\Game g
            JOIN g.user u
            GROUP BY u.idUser
            ORDER BY totalScore DESC'
        );

        $joueurs = $query->getResult();

        return $this->render('rank/rank.html.twig', [
            'joueurs' => $joueurs,
        ]);
    }
}
*/


namespace App\Controller;

use App\Repository\UserRepository; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RankController extends AbstractController
{
    #[Route('/rank', name: 'ferrovipath_rank', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $joueurs = $userRepository->findRanking();

        return $this->render('rank/rank.html.twig', [
            'joueurs' => $joueurs,
        ]);
    }
}

?>
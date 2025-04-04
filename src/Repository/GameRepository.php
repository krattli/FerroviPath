<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * Sera utilisée pour rechercher les games déjà enregistrées dans la BDD triés par ordre d'ajout
     *
     * À savoir : si aucun parameter d'id est fourni, renvoie juste toutes les parties existantes
     *
     * @param int|null $userId
     * @return array
     */
    public function findSavedGames(?int $userId): array
    { // Fonction qui récupère la liste des parties auvegardées du joueur
        $qb = $this->createQueryBuilder('g')
            ->andWhere('g.deletedAt IS NULL');
        if ($userId !== null) {
            $qb->andWhere('g.user = :userId')
                ->setParameter('userId', $userId);
        }
        return $qb->orderBy('g.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return Game[] Returns an array of Game objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Game
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

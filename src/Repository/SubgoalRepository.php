<?php

namespace App\Repository;

use App\Entity\Subgoal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Subgoal>
 *
 * @method Subgoal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subgoal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subgoal[]    findAll()
 * @method Subgoal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubgoalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subgoal::class);
    }

//    /**
//     * @return Subgoal[] Returns an array of Subgoal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Subgoal
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

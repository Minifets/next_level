<?php

namespace App\Repository\Milestone;

use App\Entity\Milestone\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stage>
 *
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    public function findNextStage(?Stage $currentStage): ?Stage
    {
        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder
            ->andWhere('s.stageOrder > :currentStageOrder')
            ->setParameter('currentStageOrder', $currentStage->getStageOrder())
            ->orderBy('s.stageOrder', 'ASC')
            ->setMaxResults(1)
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}

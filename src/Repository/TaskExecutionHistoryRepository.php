<?php

namespace App\Repository;

use App\Entity\TaskExecutionHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskExecutionHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskExecutionHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskExecutionHistory[]    findAll()
 * @method TaskExecutionHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskExecutionHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskExecutionHistory::class);
    }

    // /**
    //  * @return TaskExecutionHistory[] Returns an array of TaskExecutionHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TaskExecutionHistory
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

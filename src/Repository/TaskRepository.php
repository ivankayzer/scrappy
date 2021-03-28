<?php

namespace App\Repository;

use App\Entity\Task;
use App\Enums\TaskStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
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
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllForUser(int $userId)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.user = :val')
            ->setParameter('val', $userId)
            ->getQuery()
            ->getResult();
    }

    public function findNeverRun()
    {
        return $this->findHasAtLeastOneScriptAndActive()
            ->andWhere('t.last_checked is null')
            ->getQuery()
            ->getResult();
    }

    public function findWaitingForCheck()
    {
        return $this->findHasAtLeastOneScriptAndActive()
            ->andWhere('t.check_frequency > 0')
            ->andWhere("DATE_ADD(t.last_checked, t.check_frequency, 'SECOND') < CURRENT_TIMESTAMP()")
            ->getQuery()
            ->getResult();
    }

    private function findHasAtLeastOneScriptAndActive(): QueryBuilder
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.scripts', 's')
            ->andWhere('t.status = :status')
            ->setParameter('status', TaskStatus::active()->value)
            ->andWhere('s.task is not null')
            ->groupBy('s.task');
    }
}

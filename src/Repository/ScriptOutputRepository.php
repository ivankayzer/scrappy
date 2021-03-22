<?php

namespace App\Repository;

use App\Entity\Script;
use App\Entity\ScriptOutput;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ScriptOutput|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScriptOutput|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScriptOutput[]    findAll()
 * @method ScriptOutput[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScriptOutputRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScriptOutput::class);
    }

    // /**
    //  * @return ScriptOutput[] Returns an array of ScriptOutput objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ScriptOutput
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findPrevious(Script $script): ?ScriptOutput
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.script = :val')
            ->orderBy('s.id', 'DESC')
            ->setParameter('val', $script)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}

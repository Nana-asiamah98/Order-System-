<?php

namespace App\Repository;

use App\Entity\OrderLogs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderLogs|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderLogs|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderLogs[]    findAll()
 * @method OrderLogs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderLogsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderLogs::class);
    }

    // /**
    //  * @return OrderLogs[] Returns an array of OrderLogs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderLogs
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

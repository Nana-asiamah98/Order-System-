<?php

namespace App\Repository;

use App\Entity\ShippingDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShippingDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShippingDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShippingDetails[]    findAll()
 * @method ShippingDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShippingDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingDetails::class);
    }

    // /**
    //  * @return ShippingDetails[] Returns an array of ShippingDetails objects
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
    public function findOneBySomeField($value): ?ShippingDetails
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

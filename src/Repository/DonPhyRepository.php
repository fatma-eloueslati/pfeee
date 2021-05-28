<?php

namespace App\Repository;

use App\Entity\DonPhy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DonPhy|null find($id, $lockMode = null, $lockVersion = null)
 * @method DonPhy|null findOneBy(array $criteria, array $orderBy = null)
 * @method DonPhy[]    findAll()
 * @method DonPhy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonPhyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DonPhy::class);
    }

    // /**
    //  * @return DonPhy[] Returns an array of DonPhy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DonPhy
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Enreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Enreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enreprise[]    findAll()
 * @method Enreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enreprise::class);
    }

    // /**
    //  * @return Enreprise[] Returns an array of Enreprise objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Enreprise
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

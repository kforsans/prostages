<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */


    public function findByFormation($nom)
    {
        $requete = $this->getEntityManager()->createQuery("SELECT s,f,e
        from App\Entity\Stage s
        JOIN s.formation f
        JOIN s.enreprise e
        WHERE f.id = :nom"
        );
        $requete->setParameter('nom',$nom);
        return $requete->execute();
    }

    public function findByEntreprise($nom)
    {
        $requete = $this->getEntityManager()->createQuery("SELECT s,f,e
        from App\Entity\Stage s
        JOIN s.formation f
        JOIN s.enreprise e
        WHERE e.id = :nom"
        );
        $requete->setParameter('nom',$nom);
        return $requete->execute();
    }

    public function findByEntrepriseAutre($value)
    {
        return $this->createQueryBuilder('s')
            ->where('s.enreprise = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByFormationAutre($value)
    {
        //Gestionnaire d'entités
        $entityManager = $this->getEntityManager();
        
        //Construction requete
        $requete = $entityManager->createQuery(
            'SELECT s 
             FROM App\Entity\Stage s
             WHERE :valeur MEMBER OF s.formation'
        );
        $requete->setParameter(':valeur', $value);

        //Executer requete + retourner
        return $requete->execute();
    }
    
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
    public function findOneBySomeField($value): ?Stage
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

<?php

namespace App\Repository;

use App\Entity\Fournisseurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fournisseurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fournisseurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fournisseurs[]    findAll()
 * @method Fournisseurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class FournisseursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fournisseurs::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Fournisseurs $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Fournisseurs $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    // /**
    //  * @return Fournisseurs[] Returns an array of Fournisseurs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fournisseurs
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function SearchNSC($nomf){
        return $this->createQueryBuilder('s')
            ->where('s.nomf like :nomf')
            ->setParameter('nomf','%'.$nomf.'%')
            ->getQuery()->getResult();
    }


    /**
     * Requête QueryBuilder
     * */
    public function orderByNom()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.nomf', 'ASC')
            ->getQuery()->getResult();
    }
    /**
     * Requête QueryBuilder
     * */
    public function orderByPrenom()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.prenomf', 'ASC')
            ->getQuery()->getResult();
    }
    /**
     * Requête QueryBuilder
     * */
    public function orderByEmail()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.addf', 'ASC')
            ->getQuery()->getResult();
    }
    /**
     * Requête QueryBuilder
     * */
    public function orderByCateg()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.catf', 'ASC')
            ->getQuery()->getResult();
    }
    /**
     * Requête QueryBuilder
     * */
    public function orderBytel()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.telf', 'ASC')
            ->getQuery()->getResult();
    }

}



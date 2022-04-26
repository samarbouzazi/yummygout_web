<?php

namespace App\Repository;

use App\Entity\Stocks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stocks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stocks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stocks[]    findAll()
 * @method Stocks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class StocksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stocks::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Stocks $entity, bool $flush = true): void
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
    public function remove(Stocks $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Classroom[] Returns an array of Classroom objects
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
    public function findOneBySomeField($value): ?Classroom
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @param $id
     * @return float|int|mixed|string
     */
    public function listStobyfour($id)
    {
        return $this->createQueryBuilder('s')
            ->join('s.idf', 'c')
            ->addSelect('c')
            ->where('c.idf=:id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $find
     * @return float|int|mixed|string
     */

    public function findMulti($find)
    {
        $q=$this->createQueryBuilder('m')
            ->where('m.nomf LIKE :find')
            ->orWhere('m.prenomf LIKE :find')
            ->orWhere('m.catf LIKE :find')
            ->orWhere('m.telf LIKE :find')
            ->orWhere('m.addf LIKE :find')
            ->setParameter(':find',"%$find%");
        return $q->getQuery()->getResult();
    }
    /**
     * @return void
     */
    public function countByfour(){
        $query = $this->createQueryBuilder('a')
            ->join('a.idf','c')
            ->select('c.nomf as name, COUNT(a) as count')
            ->groupBy('c')
        ;
        return $query->getQuery()->getResult();

    }
    public function countByEvent(){
        return $this->createQueryBuilder('a')
            ->join('a.event', 'c')
            ->addSelect('c.title as titre ,COUNT(a) as formationsNombre')
            ->groupBy('c')
            ->getQuery()
            ->getResult();

    }

}
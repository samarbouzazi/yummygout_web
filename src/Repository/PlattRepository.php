<?php

namespace App\Repository;
use App\Entity\Categorie;
use App\Entity\Platt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;



/**
 * @method Platt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Platt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Platt[]    findAll()
 * @method Platt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlattRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Platt::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Platt $entity, bool $flush = true): void
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
    public function remove(Platt $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

  //public function listProByptdej($id)
  //  {
    //    return $this->createQueryBuilder('p')
      //      ->join('p.idcatt', 'c')
        //    ->addSelect('p')
         //   ->where('c.nomcat=:nom')
           // ->setParameter('nom',$id)
            //->getQuery()
            //->getResult();
  //  }

    /**
     * @param $id
     * @return float|int|mixed|string
     */
    public function listplatbycat($id)
    {
        return $this->createQueryBuilder('s')
            ->join('s.idcatt', 'c')
            ->addSelect('c')
            ->where('c.idcatt=:id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }


    public function order_By_Nnom()

    public function order_By_Nom()

    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.Nomplat', 'ASC')
            ->getQuery()->getResult();
    }


    /**
     * Requête QueryBuilder
     * */
    public function orderBynom()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.nomplat', 'ASC')
            ->getQuery()->getResult();
    }

    /**
     * Requête QueryBuilder
     * */
    public function orderBydesc()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.descplat', 'ASC')
            ->getQuery()->getResult();
    }

    /**
     * Requête QueryBuilder
     * */
    public function orderByprixPlat()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.prixPlat', 'ASC')
            ->getQuery()->getResult();
    }

    /**
     * @return void
     */
    public function countByfour(){
        $query = $this->createQueryBuilder('a')
            ->join('a.idcatt','c')
            ->select('c.nomcat as name, COUNT(a) as count')
            ->groupBy('c')
        ;
        return $query->getQuery()->getResult();

    }

=======

}


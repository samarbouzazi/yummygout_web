<?php

namespace App\Repository;

use App\Entity\Panier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Panier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panier[]    findAll()
 * @method Panier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panier::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Panier $entity, bool $flush = true): void
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
    public function remove(Panier $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param $id
     * @return float|int|mixed|string
     */
    public function list($id)
    {
        return $this->createQueryBuilder('p')
            ->join('p.idplat', 'pl')
            ->addSelect('pl')
            ->where('pl.idplat=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }







    // /**
    //  * @return Panier[] Returns an array of Panier objects
    //  */

    public function findByclient($value)
    {

        return $this->createQueryBuilder('p')
            ->andWhere('p.client = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Panier
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}

    public function findclient($id){
        return $this->createQueryBuilder('p')
            ->join('p.order' , 'o')
            ->addSelect('o')
            ->where('p.idpanier =:id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
}
*/
    public function OrderByQuntasc()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('select p from App\Entity\Panier p order by p.quantite ASC');
        return $query->getResult();
    }

    public function OrderByQuntdesc()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('select p from App\Entity\Panier p order by p.quantite DESC');
        return $query->getResult();
    }

//    public function OrderByprixtasc()
//    {
//        $em = $this->getEntityManager();
//        $query = $em->createQuery('select p from App\Entity\Panier p order by p.id ASC');
//        return $query->getResult();
//    }
//
//    public function OrderByprixtdesc()
//    {
//        $em = $this->getEntityManager();
//        $query = $em->createQuery('select p from App\Entity\Panier p order by p.prix DESC');
//        return $query->getResult();
//    }

    public function OrderByidasc()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('select p from App\Entity\Panier p order by p.idpanier ASC');
        return $query->getResult();
    }

    public function OrderByiddesc()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('select p from App\Entity\Panier p order by p.idpanier DESC');
        return $query->getResult();
    }
//    public function OrderByidplatasc()
//    {
//        $em = $this->getEntityManager();
//        $query = $em->createQuery('select p from App\Entity\Panier p inner join App\Entity\Platt pp on p.idplat = pp.idplat order by p.idpanier ASC');
//        return $query->getResult();
//    }
//
//    public function OrderByidplatdesc()
//    {
//        $em = $this->getEntityManager();
//        $query = $em->createQuery('select p from App\Entity\Panier p inner join App\Entity\Platt pp on p.idplat = pp.idplat order by p.idpanier DESC');
//        return $query->getResult();
//    }

    public function SearchPanier($panier)
    {
        return $this->createQueryBuilder('s')
            ->join('s.idplat','p')
            ->addSelect('p')
            ->where('s.quantite like :NSC or p.prixPlat like :NSC or s.idpanier like :NSC or p.nomplat like :NSC or s.client like :NSC ')
            ->setParameter('NSC', '%'.$panier.'%')
            ->getQuery()->getResult();
    }



}
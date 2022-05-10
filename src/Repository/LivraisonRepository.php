<?php

namespace App\Repository;

use App\Entity\Livraison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livraison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livraison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livraison[]    findAll()
 * @method Livraison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivraisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livraison::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Livraison $entity, bool $flush = true): void
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
    public function remove(Livraison $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Livraison[] Returns an array of Livraison objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livraison
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function OrderByRefDQL(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.reflivraison ASC');
        return $query->getResult();
    }
    public function OrderByRefDescDQL(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.reflivraison DESC');
        return $query->getResult();
    }
    public function OrderByEtatasc(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.etat ASC');
        return $query->getResult();
    }
    public function OrderByEtatdesc(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.etat DESC');
        return $query->getResult();
    }
    public function OrderByDateasc(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.date ASC');
        return $query->getResult();
    }
    public function OrderByDatedesc(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.date DESC');
        return $query->getResult();
    }
    public function OrderByMatriculeasc(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.idlivreur ASC');
        return $query->getResult();
    }
    public function OrderByMatriculedesc(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.idlivreur DESC');
        return $query->getResult();
    }
    public function OrderByRueasc(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.rueliv ASC');
        return $query->getResult();
    }
    public function OrderByRuedesc(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.rueliv DESC');
        return $query->getResult();
    }
    public function OrderByRegionasc(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.region ASC');
        return $query->getResult();
    }
    public function OrderByRegiondesc(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select l from App\Entity\livraison l order by l.region DESC');
        return $query->getResult();
    }
 public function findByMultiple($searchValue)
    {
        return $this->createQueryBuilder('l')
            ->join('l.idlivreur', 'liv')
            ->addSelect('liv')
            ->where('l.reflivraison LIKE :ref or l.etat LIKE :etat or l.date LIKE :date or l.rueliv Like :rue or l.region Like :region or liv.matricule LIKE :livreur')
            ->setParameters(
                ['ref' => '%'.$searchValue.'%', 'etat'=>'%'.$searchValue.'%',
                    'date'=>'%'.$searchValue.'%' , 'rue'=>'%'.$searchValue.'%', 'region'=>'%'.$searchValue.'%', 'livreur'=>'%'.$searchValue.'%'
                ])
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $idd
     * @return number of "count"
     */
    public function countlivraisonparlivreur($idd){
        return $this->createQueryBuilder('l')
            ->select('COUNT(l) as nb')->where('l.idlivreur = :idliv')
            ->setParameter('idliv',$idd)->getQuery()->getResult();
    }

    /**
     * @return float|int|mixed|string
     */
    public function countnb(){
        return $this->createQueryBuilder('l')
            ->select('COUNT(l) as nb')
           ->where('l.etat = :idliv')
            ->setParameter('idliv',"en cours")->getQuery()->getResult();
    }
}

<?php

namespace App\Repository;

use App\Entity\Reclamantionlivraison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Validator\Constraints\Count;

/**
 * @method Reclamantionlivraison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamantionlivraison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamantionlivraison[]    findAll()
 * @method Reclamantionlivraison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamantionlivraisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamantionlivraison::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Reclamantionlivraison $entity, bool $flush = true): void
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
    public function remove(Reclamantionlivraison $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Reclamantionlivraison[] Returns an array of Reclamantionlivraison objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reclamantionlivraison
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByMultiple($searchValue)
    {
        return $this->createQueryBuilder('r')
            ->join('r.idLivraison', 'l')
            ->join('l.idlivreur','liv')
            ->where('r.reclamation LIKE :rec or r.createdat LIKE :cdate or r.updatedat LIKE :update or l.reflivraison Like :ref or l.etat LIKE :etat or l.date LIKE :date or liv.matricule LIKE :mat')
            ->setParameters(
                ['rec' => '%'.$searchValue.'%', 'cdate'=>'%'.$searchValue.'%',
                    'update'=>'%'.$searchValue.'%', 'date'=>'%'.$searchValue.'%',
                    'ref'=>'%'.$searchValue.'%', 'etat'=>'%'.$searchValue.'%', 'mat'=>'%'.$searchValue.'%'
                ])
            ->getQuery()
            ->getResult();
    }
/*public function getlivreurs(){
        return $this->createQueryBuilder('l, (SELECT COUNT(r.idlivraison) from App\Entity\Reclamantionlivraison r as Hidden nb where r.idlivraison= l.idlivraison) as nbre')
            ->from('App/Entit/Livraison')
            ->orderBy('nbre', 'DESC')->getQuery()->getResult();
 }*/
    /**
     * @return number of "Reclamations" per day
     */
    public function countbydate(){
        $res=$this->createQueryBuilder('r')
           ->select('SUBSTRING(r.createdat, 1, 10) as daterec, COUNT(r) as nb')
            ->groupBy('daterec');
            return $res->getQuery()->getResult();
    }
    public function countbysujets(){
        $res=$this->createQueryBuilder('r')
            ->select('r.sujetrec as sujets, Count(r) as nbre')
            ->groupBy('sujets');
            return $res->getQuery()->getResult();
}
    /**
     * @return void
     */
    public function getsujets(){
        $res=$this->createQueryBuilder('r')
            ->select('sujetrec as sujet')
            ->distinct(true)->getQuery()->getResult();
    }
}

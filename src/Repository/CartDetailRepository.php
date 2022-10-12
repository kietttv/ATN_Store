<?php

namespace App\Repository;

use App\Entity\CartDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CartDetail>
 *
 * @method CartDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartDetail[]    findAll()
 * @method CartDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartDetail::class);
    }

    public function add(CartDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CartDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //SELECT cd.id as id 
//FROM cart_detail cd, cart c
//WHERE cd.cart_id = c.id AND c.user_id = 10 AND cd.cart_id = 46 AND cd.product_id = 9;
    /**
    * @return CartDetail[] Returns an array of CartDetail objects
    */
   public function checkCartDetail($idpro, $idca)
   {
       return $this->createQueryBuilder('c')
           ->select('COUNT(c.id) as count, c.Quantity as quantity, c.id as id')
           ->innerJoin('c.product', 'p')
           ->Where('p.id = :idpro')
           ->setParameter('idpro', $idpro)
           ->innerJoin('c.cart', 'ca')
           ->andWhere('ca.id = :idca')
           ->setParameter('idca', $idca)
           ->getQuery()
           ->getResult()
       ;
   }

    /**
    * @return CartDetail[] Returns an array of CartDetail objects
    */
    public function idCartDetail($idpro, $idca)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id as id')
            ->innerJoin('c.product', 'p')
            ->Where('p.id = :idpro')
            ->setParameter('idpro', $idpro)
            ->innerJoin('c.cart', 'ca')
            ->andWhere('ca.id = :idca')
            ->setParameter('idca', $idca)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return CartDetail[] Returns an array of CartDetail objects
    */
    public function countCart($idca)
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id) as count')
            ->innerJoin('c.cart', 'ca')
            ->andWhere('ca.id = :idca')
            ->setParameter('idca', $idca)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return CartDetail[] Returns an array of CartDetail objects
    */
    public function addCart($idca)
    {
        return $this->createQueryBuilder('c')
            ->select('p.Price as price, c.Quantity as quantity, 
            (p.Price*c.Quantity) as total, p.id as proid, c.id as cdid, p.Productquantity as proquantity')
            ->innerJoin('c.cart', 'ca')
            ->andWhere('ca.id = :idca')
            ->setParameter('idca', $idca)
            ->innerJoin('c.product', 'p')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return CartDetail[] Returns an array of CartDetail objects
    */
    public function checkUpdateCart($idca)
    {
        return $this->createQueryBuilder('c')
            ->select('p.Productquantity as proquantity')
            ->Where('c.id = :idca')
            ->setParameter('idca', $idca)
            ->innerJoin('c.product', 'p')
            ->getQuery()
            ->getResult()
        ;
    }


//    /**
//     * @return CartDetail[] Returns an array of CartDetail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CartDetail
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cart>
 *
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function add(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // SELECT p.productimage, p.productname, cd.quantity, p.price 
    // FROM user u, cart c, cart_detail cd, product p
    // WHERE u.id = c.user_id AND c.id = cd.cart_id AND cd.product_id = p.id
    // AND u.id = 10 AND c.id = 46;

    /**
    * @return Cart[] Returns an array of Cart objects
    */
   public function showCart($uid, $cid)
   {
       return $this->createQueryBuilder('c')
           ->select('p.Productimage, p.Productname, cd.Quantity as Productquantity, p.Price, cd.id as id')
           ->innerJoin('c.user', 'u')
           ->innerJoin('c.cartdetail', 'cd')
           ->innerJoin('cd.product', 'p')
           ->Where('c.user = :uid')
           ->setParameter('uid', $uid)
           ->andWhere('c.id = :cid')
           ->setParameter('cid', $cid)
           ->getQuery()
           ->getResult()
       ;
   }

   /**
    * @return Cart[] Returns an array of Cart objects
    */
    public function sumCart($uid, $cid){
        return $this->createQueryBuilder('c')
            ->select('SUM(cd.Quantity*p.Price) as total')
            ->innerJoin('c.cartdetail', 'cd')
            ->innerJoin('cd.product', 'p')
            ->Where('c.user = :uid')
            ->setParameter('uid', $uid)
            ->andWhere('c.id = :cid')
            ->setParameter('cid', $cid)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
    * @return Cart[] Returns an array of Cart objects
    */
    public function test($id){
        return $this->createQueryBuilder('c')
            ->select('c.id as id')
            ->Where('c.user = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }


//    /**
//     * @return Cart[] Returns an array of Cart objects
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

//    public function findOneBySomeField($value): ?Cart
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

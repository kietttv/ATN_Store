<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function add(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
   /**
    * @return Order[] Returns an array of Order objects
    */
   public function maxOrder()
   {
       return $this->createQueryBuilder('o')
           ->select('MAX(o.id) as id')
           ->getQuery()
           ->getResult()
       ;
   }

    /**
    * @return Order[] Returns an array of Order objects
    */
    public function indexOrder()
    {
        return $this->createQueryBuilder('o')
            ->select('o.id as Oid, o.Orderdate, o.Deliverydate, o.Address, 
            o.Payment, o.Status, u.id as user')
            ->innerJoin('o.user', 'u')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Order[] Returns an array of Order objects
    */
    public function payOrder($id)
    {
        return $this->createQueryBuilder('o')
            ->select('o.Payment as payment')
            ->where('o.id = :id' )
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }


//    /**
//     * @return Order[] Returns an array of Order objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Order
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

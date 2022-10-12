<?php

namespace App\Repository;

use App\Entity\OrderDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderDetail>
 *
 * @method OrderDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDetail[]    findAll()
 * @method OrderDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDetail::class);
    }

    public function add(OrderDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    *@return OrderDetail[] Returns an array of OrderDetail objects
    */
    public function historyOrder($id)
    {
        return $this->createQueryBuilder('od')
            ->select('o.Orderdate as orderdate, o.Deliverydate as deliverydate, 
            o.Status as status, od.Total as total, od.Price as price, p.Productname as productname, 
            p.Productimage as image, od.OderProQuan as quantity, p.id as id')
            ->innerJoin('od.Orderid', 'o')
            ->innerJoin('od.Productid', 'p')
            ->where('o.user = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    *@return OrderDetail[] Returns an array of OrderDetail objects
    */
    public function showOrderDetail($id)
    {
        return $this->createQueryBuilder('o')
            ->select('o.id as odid, o.OderProQuan as quantity, o.Price as price, o.Total as total,
            od.id as order, p.id as product')
            ->innerJoin('o.Orderid', 'od')
            ->innerJoin('o.Productid', 'p')
            ->where('o.Orderid = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return OrderDetail[] Returns an array of OrderDetail objects
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

//    public function findOneBySomeField($value): ?OrderDetail
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

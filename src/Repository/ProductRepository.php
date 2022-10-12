<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
   /**
    * @return Product[] Returns an array of Product objects
    */
   public function indexProduct()
   {
       $entity = $this->getEntityManager();
       return $entity->createQuery('
       SELECT p.id as productid, p.Productname, p.Price,
       p.Productdes, p.Productquantity, p.Productimage, b.id as brandid
       FROM App\Entity\Product p, App\Entity\Brand b WHERE p.Brandid = b.id
       ')
       ->getArrayResult()
       ;
   }

      /**
    * @return Product[] Returns an array of Product objects
    */
    public function indexProductHome()
    {
        $entity = $this->getEntityManager();
        return $entity->createQuery('
        SELECT p.id, p.Productname, p.Price,
        p.Productdes, p.Productquantity, p.Productimage
        FROM App\Entity\Product p WHERE p.Status = 1 AND p.Productquantity > 0
        ')
        ->getArrayResult()
        ;
    }

   /**
    * @return Product[] Returns an array of Product objects
    */
    public function findProductByName($productname)
   {
       return $this->createQueryBuilder('p')
            ->select('p.id, p.Productname, p.Price, p.Productimage')
           ->Where('p.Productname LIKE :productname')
           ->setParameter('productname', "%${productname}%")
           ->andWhere('p.Status = 1')
           ->getQuery()
           ->getResult()
       ;
   }

      /**
    * @return Product[] Returns an array of Product objects
    */
    public function countProductByName($productname)
   {
       return $this->createQueryBuilder('p')
            ->select('COUNT(p.id) as count')
           ->Where('p.Productname LIKE :productname')
           ->setParameter('productname', "%${productname}%")
           ->andWhere('p.Status = 1')
           ->getQuery()
           ->getResult()
       ;
   }

      /**
    * @return Product[] Returns an array of Product objects
    */
    public function imageProduct($id)
    {
        $entity = $this->getEntityManager();
        return $entity->createQuery('
        SELECT p.Productimage, p.Productquantity as quantity FROM App\Entity\Product p WHERE p.id = :id
        ') ->setParameter('id', $id)
        ->getArrayResult()
        ;
    }

      /**
    * @return Product[] Returns an array of Product objects
    */
    public function compareProducts($proIdA, $proIdB)
   {
       return $this->createQueryBuilder('p')
            ->select('p.Productname, p.Price, p.Productimage, p.Productdes')
           ->Where('p.id = :proIdA OR p.id = :proIdB')
           ->setParameter('proIdA', "$proIdA")
           ->setParameter('proIdB', "$proIdB")
           ->getQuery()
           ->getResult()
       ;
   }


//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    /**
    * @return User[] Returns an array of User objects
    */
   public function allAccount($role)
   {
       return $this->createQueryBuilder('u')
           ->select('u.id, u.username, u.Fullname, u.Gender,
           u.Address, u.Telephone, u.Email, u.Birthdate, u.roles as role')
           ->andWhere('u.roles LIKE :role')
           ->setParameter('role', "%{$role}%")
           ->getQuery()
           ->getResult()
       ;
   }

    /**
    * @return User[] Returns an array of User objects
    */
    public function birtAc():array
    {
        return $this->createQueryBuilder('u')
            ->select('u.Birthdate')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /**
    * @return User[] Returns an array of User objects
    */
    public function orderUser($id)
    {
        return $this->createQueryBuilder('u')
            ->select('u.Address as address')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /**
    * @return User[] Returns an array of User objects
    */
   public function checkSameUser($userName): array
   {
       return $this->createQueryBuilder('u')
            ->select('count(u.username) as count')
            ->andWhere('u.username = :userName')
            ->setParameter('userName', $userName)
            ->getQuery()
            ->getResult()
       ;
   }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

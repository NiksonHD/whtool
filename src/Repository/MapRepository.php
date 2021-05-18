<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapRepository extends \Doctrine\ORM\EntityRepository
{
    
     public function __construct(\Doctrine\ORM\EntityManagerInterface $em, \Doctrine\ORM\Mapping\ClassMetadata $metaData = null) {
        parent::__construct($em, $metaData == null ? 
                new \Doctrine\ORM\Mapping\ClassMetadata(\App\Entity\Map::class) : $metaData);
    }
    public function findBySap(string $sapNum = null) {
        $sapNum = "%" . $sapNum . "%";
        return $this->createQueryBuilder('m')
                        ->select('m')
//                        ->from('AppBundle:Tile', true)
                        ->where('m.sapNum like :sapNum')
                        ->setParameter('sapNum', $sapNum)
                        ->getQuery()
                        ->getResult();
    }
    
    
    public function update($map) {

        try {
            $this->_em->merge($map);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $e) {
            return false;
        }
    }

    
   

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

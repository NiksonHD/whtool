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
    
    public function findByDate($date) {
        $date = '%'.$date. '%';

        return $this->createQueryBuilder('m')
                        ->select('m')
                        ->Where('m.updateDate like :date')
                        ->setParameter('date', $date)
                        ->orderBy('m.updateDate', 'desc')
                        ->getQuery()
                        ->getResult();
    }

    
   

}

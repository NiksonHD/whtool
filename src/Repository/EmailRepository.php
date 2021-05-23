<?php

namespace App\Repository;

use App\Entity\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Email|null find($id, $lockMode = null, $lockVersion = null)
 * @method Email|null findOneBy(array $criteria, array $orderBy = null)
 * @method Email[]    findAll()
 * @method Email[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Email::class);
    }
    
    
      public function insert($email) {
        try {
            $this->_em->persist($email);
            $this->_em->flush();
            return true;
        } catch (\Doctrine\ORM\OptimisticLockException $ex) {
            return false;
        }
    }
    
    public function delete($email){
           return   $this->createQueryBuilder('e')
                ->delete()
                ->where('e.id= :id' )
                ->getQuery()
                ->execute(['id'=> $email->getId()]);
        
    }

}

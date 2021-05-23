<?php

namespace App\Repository;

use App\Entity\DailyInputs;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\OptimisticLockException;


class DailyRepository extends EntityRepository
{
    
    public function __construct(EntityManagerInterface $em, ClassMetadata $metaData = null) {
        parent::__construct($em, $metaData == null ? 
                new ClassMetadata(DailyInputs::class) : $metaData);
    }
    
    public function insert(DailyInputs $daily) {
        try {
            $this->_em->persist($daily);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $e) {
            return false;
        }
    }
  
 public function findDailyByDate($date) {
        $date = '%'.$date. '%';

        return $this->createQueryBuilder('d')
                        ->select('d, t.articleNum, t.articleName')
//                        ->from('App:Daily', true)
                        ->join('App\Entity\Tile', 't', 'WITH', 'd.article = t.id')
                        ->andWhere('d.inputDate like :date')
                        ->setParameter('date', $date)
                        ->orderBy('d.inputDate', 'desc')
                        ->getQuery()
                        ->getResult();
    }

    
    
    
}

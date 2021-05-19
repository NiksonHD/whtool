<?php

namespace App\Repository;

/**
 * ListRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ListRepository extends \Doctrine\ORM\EntityRepository {

    public function __construct(\Doctrine\ORM\EntityManagerInterface $em, \Doctrine\ORM\Mapping\ClassMetadata $metaData = null) {
        parent::__construct($em, $metaData == null ?
                        new \Doctrine\ORM\Mapping\ClassMetadata(\App\Entity\Lists::class) : $metaData);
    }

    public function insert($list) {
        try {
            $this->_em->persist($list);
            $this->_em->flush();
            return true;
        } catch (\Doctrine\ORM\OptimisticLockException $ex) {
            return false;
        }
    }

    public function findListByDate($date) {
        $date = '%'.$date. '%';

        return $this->createQueryBuilder('l')
                        ->select('l')
                        ->Where('l.nameList like :date')
                        ->setParameter('date', $date)
                        ->orderBy('l.nameList', 'desc')
                        ->getQuery()
                        ->getResult();
    }
     public function update($list) {
        try {
            $this->_em->merge($list);
            $this->_em->flush();
            return true;
        } catch (\Doctrine\ORM\OptimisticLockException $ex) {
            return false;
        }
    }

}

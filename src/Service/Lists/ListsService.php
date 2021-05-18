<?php

namespace App\Service\Lists;

use App\Entity\Lists;
use App\Form\ListsType;
use App\Repository\ListRepository;
use App\Service\Tile\TileServiceInterface;
use Exception;

//use App\Repository\ListRepository;

class ListsService implements ListsServiceInterface {
    /**
     * 
     * @var ListRepository
     */
    private $listRepository;
    
    /**
     * 
     * @var TileServiceInterface
     */
   private $tileService;
    

   public function __construct(ListRepository $listRepository, TileServiceInterface $tileService) {
       $this->listRepository = $listRepository;
       $this->tileService = $tileService;
   }

       public function create($list) {
        $errors = false;
        for ($i = 1; $i < 9; $i++) {
            $getMethod = 'getSap' . $i;
            $setMethod = 'setError' . $i;
            if($list->$getMethod() !== null){
            try {
                
                $tile = new \App\Entity\Tile();
                $tile->setArticleNum($list->$getMethod());
                $this->tileService->getTileInfoForList($tile);
            } catch (Exception $ex) {
                $errors = true;
                $list->$setMethod($ex->getMessage());
                
            }
            }
        }
        if(!$errors){

        $sapString = $list->getSap1() . ' ' . $list->getQ1() . ' ' .
                $list->getSap2() . ' ' . $list->getQ2() . ' ' .
                $list->getSap3() . ' ' . $list->getQ3() . ' ' .
                $list->getSap4() . ' ' . $list->getQ4() . ' ' .
                $list->getSap5() . ' ' . $list->getQ5() . ' ' .
                $list->getSap6() . ' ' . $list->getQ6() . ' ' .
                $list->getSap7() . ' ' . $list->getQ7() . ' ' .
                $list->getSap8() . ' ' . $list->getQ8();
        $sapString = trim($sapString);
        $list->setSapList($sapString);
        
//        $this->listsService->create($list);
//        $lastList = $this->listsService->getLastInsert();
//        $id = $lastList->getId();


        return $this->listRepository->insert($list);
        }
        return $list;
    }

    public function getAll() {
        
    }

    public function getOneById($id) {
        return $this->listRepository->find($id);
    }

    public function getLastInsert() {
        return $this->listRepository->findBy([], ['id' => 'DESC'], 1)[0];
    }

    public function getAllByDate($date) {
        return $this->listRepository->findListByDate($date);
    }

    public function edit(Lists $list) {
        return $this->listRepository->update($list);
    }

}

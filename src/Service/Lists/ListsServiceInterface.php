<?php



namespace App\Service\Lists;

use App\Entity\Lists;


interface ListsServiceInterface {
    /**
     * return \App\Entity\Lists
     */
    public function getOneById($id);
    public function getAll();
    public function getAllByDate($date);
    
    public function create(Lists $list);
    
    public function edit(Lists $list);
    public function getLastInsert();
    
    
    
    
}

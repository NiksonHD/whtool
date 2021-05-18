<?php


namespace App\Service\Map;

use App\Entity\Map;




interface MapServiceInterface {
    
public function findTileAdress(string $sapNum);    
    

public function updateTileAdress(Map $map);

public function findOneByCell(string $cell);
}

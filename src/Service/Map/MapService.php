<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\Map;

use App\Entity\Map;
use App\Repository\MapRepository;
use App\Service\Tile\TileServiceInterface;
use Symfony\Component\Config\Definition\Exception\Exception;




class MapService implements MapServiceInterface {
    
    
    /**
     *
     * @var MapRepository
     */
    
    
    private $mapRepository;
    
    
    
    
    function __construct(MapRepository $mapRepository) {
        $this->mapRepository = $mapRepository;
    }

            
    public function findTileAdress(string $sapNum) {
        if($sapNum == '0'){

            return $this->mapRepository->findBy([], ['updateDate' => 'DESC'], 1);
        }
        return $this->mapRepository->findBySap($sapNum);    
        
        
        
    }

    public function updateTileAdress(Map $map) {
        
        return $this->mapRepository->update($map);
    }
    
    public function findOneByCell(string $cell) {
        $cell = $this->digitsToLettersAdress($cell);
        $output = $this->mapRepository->findBy(['tileCell' => $cell]);
        if (empty($output)) {
                throw new Exception($cell. ' - Несъществуваща клетка!',2);
            }
        return $output[0];
    }
    
    private function digitsToLettersAdress($tileNumber) {
        if (strlen($tileNumber) == 3 || strlen($tileNumber) == 4) {
            $tileAdress = $tileNumber;
            $lastCharIndex = strlen($tileAdress) - 1;
            $firstChar = substr($tileAdress, 0, 1);
            $lastChar = substr($tileAdress, -1);
            if ($firstChar == '1') {
                $tileAdress[0] = 'a';
            } elseif ($firstChar == '2') {
                $tileAdress[0] = 'b';
            } elseif ($firstChar == '3') {
                $tileAdress[0] = 'c';
            } elseif ($firstChar == '4') {
                $tileAdress[0] = 'd';
            } elseif ($firstChar == '5') {
                $tileAdress[0] = 'e';
            } elseif ($firstChar == '6') {
                $tileAdress[0] = 'o';
            }
            if ($lastChar == '1') {
                $tileAdress[$lastCharIndex] = 'a';
            } elseif ($lastChar == '2') {
                $tileAdress[$lastCharIndex] = 'b';
            } elseif ($lastChar == '3') {
                $tileAdress[$lastCharIndex] = 'c';
            } elseif ($lastChar == '4') {
                $tileAdress[$lastCharIndex] = 'd';
            } elseif ($lastChar == '5') {
                $tileAdress[$lastCharIndex] = 'e';
            } elseif ($lastChar == '6') {
                $tileAdress[$lastCharIndex] = 'f';
            }
            $tileAdress = ucfirst($tileAdress);
            return $tileAdress;
        }
            return $tileNumber;

    }

}

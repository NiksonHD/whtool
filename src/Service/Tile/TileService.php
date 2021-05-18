<?php

namespace App\Service\Tile;

use App\Entity\Tile;
use App\Repository\TileRepository;
use App\Service\Map\MapServiceInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class TileService implements TileServiceInterface {

    /**
     *
     * @var MapServiceInterface
     */
    private $mapService;

    /**
     *
     * @var TileRepository
     */
    private $tileRepository;

    function __construct(MapServiceInterface $mapService, TileRepository $tileRepository) {
        $this->mapService = $mapService;
        $this->tileRepository = $tileRepository;
    }

    public function findTileInfo(Tile $tile) {
        $articleNum = $tile->getArticleNum();
        if (strlen($articleNum) == 1 && $articleNum == '0') {
            $tileInfo = $this->tileRepository->findBySap($articleNum);
            $cells = $this->mapService->findTileAdress($articleNum);
            $tileInfo[0]->setCells($cells);
            return $tileInfo;
        }
        if (strlen($articleNum) == 3 || strlen($articleNum) == 4) {
            $articleAdress = $this->digitsToLettersAdress($articleNum);
//            $mapObject = $this->mapRepository->findBy(['tile_Cell' => $articleAdress]);
            $mapObject = $this->mapService->findOneByCell($articleAdress);
            if (empty($mapObject)) {
                throw new Exception($tileAdress . ' - Несъществуваща клетка!');
            }
            $tileString = trim($mapObject->getSapNum());
            if ($tileString === 0) {
//                $tile = new Tile();
//                $tile->setId(1);
//                $tile->setSapNum('Празна клетка!!');
//                $tileArray [] = $tile;
//                return $tileArray;
                throw new Exception($articleAdress . " - Празна клетка!");
            }
            $tileString = str_replace('"', '', $tileString);
            $tileString = trim($tileString);
            $sapNumArray = explode(' ', $tileString);
            $tilesArray = [];
            foreach ($sapNumArray as $sapNum) {
                if (empty($this->tileRepository->findBySap($sapNum))) {
                    $cells = $this->mapService->findTileAdress($sapNum);

                    $tile = new Tile();
                    $tile->setArticleNum($sapNum);
                    $tile->setCells($cells);
                    $tilesArray [] = $tile;
                    return $tilesArray;
                }
                $tile = $this->tileRepository->findBySap($sapNum)[0];
                $cells = $this->mapService->findTileAdress($sapNum);
                $tile->setCells($cells);
                $tilesArray [] = $tile;
            }
            return $tilesArray;
        }
        if (strlen($articleNum) == 6) {
            $tileInfo = $this->tileRepository->findBySap($articleNum);
            if ((empty($tileInfo))) {
                $tile = new Tile();
                $tile->setArticleNum($articleNum);
                $tile->setArticleName('Няма данни за артикула.');
                $tileInfo [] = $tile;
                $cells = $this->mapService->findTileAdress($articleNum);
                $tileInfo[0]->setCells($cells);
                return $tileInfo;
            }
            $cells = $this->mapService->findTileAdress($articleNum);
            $tileInfo[0]->setCells($cells);
            return $tileInfo;
        }
        if (strlen($articleNum) == 13) {
            $tileInfo = $this->tileRepository->findBy(['ean' => $articleNum]);
            if (!empty($tileInfo)) {
                $cells = $this->mapService->findTileAdress($tileInfo[0]->getArticleNum());

                $tileInfo[0]->setCells($cells);

                return $tileInfo;
            }
        }
        throw new Exception($articleNum . ' - Невалидни данни!');
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

    public function getTileInfoById(string $id) {
        $cellsArray = [];
        $tile = $this->tileRepository->findBy(['id' => $id])[0];
//        $cell = $this->mapRepository->findBySap($tile->getSapNum());
        $cell = $this->mapService->findTileAdress($tile->getArticleNum());
        $tile->setCells($cell);
        $tilesArray [] = $tile;
        return $tilesArray;
    }

    public function getTileInfoForList(Tile $tile) {
        $articleNum = $tile->getArticleNum();
        if (strlen($articleNum) == 6) {
            $tileInfo = $this->tileRepository->findBySap($articleNum);
            if ((!empty($tileInfo))) {
                $tileInfo [] = $tile;
                $cells = $this->mapService->findTileAdress($articleNum);
                $tileInfo[0]->setCells($cells);
                return $tileInfo;
            }
        }
        throw new Exception($articleNum . ' - Невалидни данни!');
    }

    public function getTileInfoForChange(Tile $tile) {
        $articleNum = $tile->getArticleNum();
        if (strlen($articleNum) == 6 || $articleNum === '0') {

            $tileInfo = $this->tileRepository->findBySap($articleNum);
            if ((empty($tileInfo))) {
                $tile = new Tile();
                $tile->setArticleNum($articleNum);
                $tile->setArticleName('Няма данни за артикула.');
                $tileInfo [] = $tile;
                $cells = $this->mapService->findTileAdress($articleNum);
                $tileInfo[0]->setCells($cells);
                return $tileInfo;
            }
            $cells = $this->mapService->findTileAdress($articleNum);
            $tileInfo[0]->setCells($cells);
            return $tileInfo;
        }
        if (strlen($articleNum) == 8 || strlen($articleNum) == 13) {
            $tileInfo = $this->tileRepository->findBy(['ean' => $articleNum]);
            if (!empty($tileInfo)) {
                $cells = $this->mapService->findTileAdress($tileInfo[0]->getArticleNum());

                $tileInfo[0]->setCells($cells);

                return $tileInfo;
            }
        }
        throw new Exception($articleNum . ' - Невалидни данни!');
    }

}

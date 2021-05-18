<?php

namespace App\Service\Tile;

use App\Entity\Tile;

interface TileServiceInterface {

    public function findTileInfo(Tile $tile);

    public function getTileInfoById(string $id);

    public function getTileInfoForList(Tile $tile);
    
    public function getTileInfoForChange(Tile $tile);
}

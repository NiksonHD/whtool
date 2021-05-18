<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TileMap
 *
 * @ORM\Table(name="tile_map")
 * @ORM\Entity
 */
class Map
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tile_cell", type="string", length=250, nullable=false)
     */
    private $tileCell;

    /**
     * @var string
     *
     * @ORM\Column(name="sap_num", type="string", length=21000, nullable=false)
     */
    private $sapNum;

    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updateDate;
    
    public function __construct() {
         $this->updateDate = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTileCell(): ?string
    {
        return $this->tileCell;
    }

    public function setTileCell(string $tileCell): self
    {
        $this->tileCell = $tileCell;

        return $this;
    }

    public function getSapNum(): ?string
    {
        return $this->sapNum;
    }

    public function setSapNum(string $sapNum): self
    {
        $this->sapNum = $sapNum;

        return $this;
    }

    public function setId($id) {
        $this->id = $id;
    }

    
    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }


}

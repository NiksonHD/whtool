<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoryMap
 *
 * @ORM\Table(name="history_map")
 * @ORM\Entity
 */
class HistoryMap
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
     * @ORM\Column(name="cell", type="string", length=150, nullable=false)
     */
    private $cell;

    /**
     * @var string
     *
     * @ORM\Column(name="tile", type="string", length=10000, nullable=false)
     */
    private $tile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updateDate = 'CURRENT_TIMESTAMP';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCell(): ?string
    {
        return $this->cell;
    }

    public function setCell(string $cell): self
    {
        $this->cell = $cell;

        return $this;
    }

    public function getTile(): ?string
    {
        return $this->tile;
    }

    public function setTile(string $tile): self
    {
        $this->tile = $tile;

        return $this;
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

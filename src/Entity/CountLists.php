<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CountLists
 *
 * @ORM\Table(name="count_lists")
 * @ORM\Entity
 */
class CountLists
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
     * @ORM\Column(name="current_count", type="string", length=250, nullable=false)
     */
    private $currentCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrentCount(): ?string
    {
        return $this->currentCount;
    }

    public function setCurrentCount(string $currentCount): self
    {
        $this->currentCount = $currentCount;

        return $this;
    }


}

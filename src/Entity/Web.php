<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Web
 *
 * @ORM\Table(name="web")
 * @ORM\Entity
 */
class Web
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
     * @ORM\Column(name="order_num", type="string", length=250, nullable=false)
     */
    private $orderNum;

    /**
     * @var string
     *
     * @ORM\Column(name="delivery_num", type="string", length=250, nullable=false)
     */
    private $deliveryNum;

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

    public function getOrderNum(): ?string
    {
        return $this->orderNum;
    }

    public function setOrderNum(string $orderNum): self
    {
        $this->orderNum = $orderNum;

        return $this;
    }

    public function getDeliveryNum(): ?string
    {
        return $this->deliveryNum;
    }

    public function setDeliveryNum(string $deliveryNum): self
    {
        $this->deliveryNum = $deliveryNum;

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

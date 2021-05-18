<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticlesInfo
 *
 * @ORM\Table(name="articles_info")
 * @ORM\Entity
 */
class Tile
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
     * @ORM\Column(name="article_num", type="string", length=6, nullable=false)
     */
    private $articleNum;

    /**
     * @var string
     *
     * @ORM\Column(name="article_name", type="string", length=255, nullable=false)
     */
    private $articleName;

    /**
     * @var string
     *
     * @ORM\Column(name="ean", type="string", length=20, nullable=false)
     */
    private $ean;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="string", length=11, nullable=false)
     */
    private $quantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updateDate;
//    private $updateDate = 'CURRENT_TIMESTAMP';
    
    
     public function __construct() {
         $this->updateDate = new \DateTime('now');
    }
    
    private $cells;
    
    /**
     * 
     * @var string
     */
    
    private $order;
    
    
    public function getOrder(): string {
        return $this->order;
    }

    public function setOrder(string $order): self{
        $this->order = $order;
        
        return $this;
    }

        
    function getCells(){
        return $this->cells;
    }

    function setCells(array $cells) {
        $this->cells = $cells;
    }

    
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleNum(): ?string
    {
        return $this->articleNum;
    }

    public function setArticleNum(string $articleNum): self
    {
        $this->articleNum = $articleNum;

        return $this;
    }

    public function getArticleName(): ?string
    {
        return $this->articleName;
    }

    public function setArticleName(string $articleName): self
    {
        $this->articleName = $articleName;

        return $this;
    }

    public function getEan(): ?string
    {
        return $this->ean;
    }

    public function setEan(string $ean): self
    {
        $this->ean = $ean;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;

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

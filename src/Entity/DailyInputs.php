<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DailyInputs
 *
 * @ORM\Table(name="daily_inputs")
 * @ORM\Entity
 */
class DailyInputs {

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
     * @ORM\Column(name="input", type="string", length=256, nullable=true)
     */
    private $input;

    /**
     * @var string
     *
     * @ORM\Column(name="tile_description", type="string", length=255, nullable=true)
     */
    private $tileDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="input_date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $inputDate;

    /**
     * @var Tile
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Tile")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")

     * 
     */
    private $article;

    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     * 
     */
    private $userId;

    /**
     *
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="searches")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * 
     * @var string 
     * 
     * @ORM\Column(name="ip_adress", type="string", length=256, nullable=true)
     */
    private $ipAdress;
    
    /**
     * 
     * @var string
     * 
     * @ORM\Column(name="device_zone", type="string", length=32, nullable=true)
     */
    private $deviceZone;
    public function getDeviceZone(): string {
        return $this->deviceZone;
    }

    public function setDeviceZone(string $deviceZone): void {
        $this->deviceZone = $deviceZone;
    }

    
        
    public function getIpAdress(): ?string {
        return $this->ipAdress;
    }

    public function setIpAdress(string $ipAdress): self {
        $this->ipAdress = $ipAdress;
        
        return $this;
    }

    
    public function getArticle(): Tile {
        return $this->article;
    }

    public function getUserId(): integer {
        return $this->userId;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function setArticle(Tile $article): void {
        $this->article = $article;
    }

    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }

    public function setUser(User $user = null): void {
        $this->user = $user;
    }

    public function __construct() {
        $this->inputDate = new \DateTime('now');
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getInput(): ?string {
        return $this->input;
    }

    public function setInput(string $input): self {
        $this->input = $input;

        return $this;
    }

    public function getTileDescription(): ?string {
        return $this->tileDescription;
    }

    public function setTileDescription(string $tileDescription): self {
        $this->tileDescription = $tileDescription;

        return $this;
    }

    public function getInputDate(): ?\DateTimeInterface {
        return $this->inputDate;
    }

    public function setInputDate(\DateTimeInterface $inputDate): self {
        $this->inputDate = $inputDate;

        return $this;
    }

}

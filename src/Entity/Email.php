<?php

namespace App\Entity;

use App\Repository\EmailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=EmailRepository::class)
 */
class Email
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Не си въвел email!")
     * @Assert\Email(message="Не е въведен валиден email!")
     * @ORM\Column(type="string", unique=true, length=255)
     */
    private $address;
    
    
   /**
    * @ORM\Column(type="string", length=32, nullable=true)
    */
    private $role;
    
    public function setId($id): self{
        $this->id = $id;
        return $this;
    }

        public function getRole() {
        return $this->role;
    }

    public function setRole($role): self {
        $this->role = $role;
        return $this;
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }
}

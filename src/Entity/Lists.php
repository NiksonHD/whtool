<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Lists
 *
 * @ORM\Table(name="lists")
 * @ORM\Entity
 */
class Lists
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
     *@Assert\NotBlank(message = "Моля въведи коментар.")
     * 
     * @ORM\Column(name="comment", type="string", length=255, nullable=false)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="name_list", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $nameList = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="sap_list", type="string", length=21000, nullable=false)
     */
    private $sapList;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="send_email", type="boolean", nullable=true)
     */
    private $sendEmail;
    
    private $sap1;
    private $sap2;
    private $sap3;
    private $sap4;
    private $sap5;
    private $sap6;
    private $sap7;
    private $sap8;
    
    private $q1;
    private $q2;
    private $q3;
    private $q4;
    private $q5;
    private $q6;
    private $q7;
    private $q8;
    
    private $error1;
    private $error2;
    private $error3;
    private $error4;
    private $error5;
    private $error6;
    private $error7;
    private $error8;
    
    
    
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

        public function getSap1() {
        return $this->sap1;
    }

    public function getSap3() {
        return $this->sap3;
    }

    public function getSap2() {
        return $this->sap2;
    }

    public function getSap4() {
        return $this->sap4;
    }

    public function getSap5() {
        return $this->sap5;
    }

    public function getSap6() {
        return $this->sap6;
    }

    public function getSap7() {
        return $this->sap7;
    }

    public function getSap8() {
        return $this->sap8;
    }

    public function getQ1() {
        return $this->q1;
    }

    public function getQ2() {
        return $this->q2;
    }

    public function getQ3() {
        return $this->q3;
    }

    public function getQ4() {
        return $this->q4;
    }

    public function getQ5() {
        return $this->q5;
    }

    public function getQ6() {
        return $this->q6;
    }

    public function getQ7() {
        return $this->q7;
    }

    public function getQ8() {
        return $this->q8;
    }

    public function getError1() {
        return $this->error1;
    }

    public function getError2() {
        return $this->error2;
    }

    public function getError3() {
        return $this->error3;
    }

    public function getError4() {
        return $this->error4;
    }

    public function getError5() {
        return $this->error5;
    }

    public function getError6() {
        return $this->error6;
    }

    public function getError7() {
        return $this->error7;
    }

    public function getError8() {
        return $this->error8;
    }

    public function setSap1($sap1): void {
        $this->sap1 = $sap1;
    }

    public function setSap3($sap3): void {
        $this->sap3 = $sap3;
    }

    public function setSap2($sap2): void {
        $this->sap2 = $sap2;
    }

    public function setSap4($sap4): void {
        $this->sap4 = $sap4;
    }

    public function setSap5($sap5): void {
        $this->sap5 = $sap5;
    }

    public function setSap6($sap6): void {
        $this->sap6 = $sap6;
    }

    public function setSap7($sap7): void {
        $this->sap7 = $sap7;
    }

    public function setSap8($sap8): void {
        $this->sap8 = $sap8;
    }

    public function setQ1($q1): void {
        $this->q1 = $q1;
    }

    public function setQ2($q2): void {
        $this->q2 = $q2;
    }

    public function setQ3($q3): void {
        $this->q3 = $q3;
    }

    public function setQ4($q4): void {
        $this->q4 = $q4;
    }

    public function setQ5($q5): void {
        $this->q5 = $q5;
    }

    public function setQ6($q6): void {
        $this->q6 = $q6;
    }

    public function setQ7($q7): void {
        $this->q7 = $q7;
    }

    public function setQ8($q8): void {
        $this->q8 = $q8;
    }

    public function setError1($error1): void {
        $this->error1 = $error1;
    }

    public function setError2($error2): void {
        $this->error2 = $error2;
    }

    public function setError3($error3): void {
        $this->error3 = $error3;
    }

    public function setError4($error4): void {
        $this->error4 = $error4;
    }

    public function setError5($error5): void {
        $this->error5 = $error5;
    }

    public function setError6($error6): void {
        $this->error6 = $error6;
    }

    public function setError7($error7): void {
        $this->error7 = $error7;
    }

    public function setError8($error8): void {
        $this->error8 = $error8;
    }

        
     public function __construct() {
         $this->nameList = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getNameList(): ?\DateTimeInterface
    {
        return $this->nameList;
    }

    public function setNameList(\DateTimeInterface $nameList): self
    {
        $this->nameList = $nameList;

        return $this;
    }

    public function getSapList(): ?string
    {
        return $this->sapList;
    }

    public function setSapList(string $sapList): self
    {
        $this->sapList = $sapList;

        return $this;
    }

    public function getSendEmail(): ?bool
    {
        return $this->sendEmail;
    }

    public function setSendEmail(?bool $sendEmail): self
    {
        $this->sendEmail = $sendEmail;

        return $this;
    }


}

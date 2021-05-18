<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Access
 *
 * @ORM\Table(name="access")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccessRepository")
 */
class Access
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="blacklistIp", type="string", length=255, unique=true)
     */
    private $blacklistIp;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set blacklistIp
     *
     * @param string $blacklistIp
     *
     * @return Access
     */
    public function setBlacklistIp($blacklistIp)
    {
        $this->blacklistIp = $blacklistIp;

        return $this;
    }

    /**
     * Get blacklistIp
     *
     * @return string
     */
    public function getBlacklistIp()
    {
        return $this->blacklistIp;
    }
}


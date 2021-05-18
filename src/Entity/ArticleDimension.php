<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleDimension
 *
 * @ORM\Table(name="article_dimension")
 * @ORM\Entity
 */
class ArticleDimension
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
     * @ORM\Column(name="ean", type="string", length=256, nullable=false)
     */
    private $ean;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="string", length=256, nullable=false)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="length", type="string", length=256, nullable=false)
     */
    private $length;

    /**
     * @var string
     *
     * @ORM\Column(name="height", type="string", length=256, nullable=false)
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="weight", type="string", length=256, nullable=false)
     */
    private $weight;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updateDate = 'CURRENT_TIMESTAMP';


}

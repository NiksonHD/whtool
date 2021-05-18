<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CsvFilesStamps
 *
 * @ORM\Table(name="csv_files_stamps")
 * @ORM\Entity
 */
class CsvFilesStamps
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
     * @ORM\Column(name="file_stamp", type="string", length=250, nullable=false)
     */
    private $fileStamp;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=250, nullable=false)
     */
    private $fileName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileStamp(): ?string
    {
        return $this->fileStamp;
    }

    public function setFileStamp(string $fileStamp): self
    {
        $this->fileStamp = $fileStamp;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }


}

<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka\File;


use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="paseka_matkas_child_files", indexes={
 *     @ORM\Index(columns={"date"})
 * })
 */
class File
{
    /**
     * @var ChildMatka
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka", inversedBy="files")
     * @ORM\JoinColumn(name="childmatka_id", referencedColumnName="id", nullable=false)
     */
    private $childmatka;
    /**
     * @var Uchastie
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinColumn(name="uchastie_id", referencedColumnName="id", nullable=false)
     */
    private $uchastie;
    /**
     * @var Id
     * @ORM\Column(type="paseka_matkas_child_file_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;
    /**
     * @var Info
     * @ORM\Embedded(class="Info")
     */
    private $info;

    public function __construct(ChildMatka $childmatka, Id $id, Uchastie $uchastie, \DateTimeImmutable $date, Info $info)
    {
        $this->childmatka = $childmatka;
        $this->id = $id;
        $this->uchastie = $uchastie;
        $this->date = $date;
        $this->info = $info;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getUchastie(): Uchastie
    {
        return $this->uchastie;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getInfo(): Info
    {
        return $this->info;
    }
}

<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Rasas;

use App\Model\Paseka\Entity\Rasas\Linias\Linia;
use App\Model\Paseka\Entity\Rasas\Linias\Id as LiniaId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_rasas")
 */
class Rasa
{
    /**
     * @var Id
     * @ORM\Column(type="paseka_rasa_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

     /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;
	
	 /**
     * @var ArrayCollection|Linia[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Paseka\Entity\Rasas\Linias\Linia",
     *     mappedBy="rasa", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $linias;

    public function __construct(Id $id, string $name, string $title)
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
		$this->linias = new ArrayCollection();
    }

    public function edit(string $name, string $title): void
    {
        $this->name = $name;
        $this->title = $title;
    }
    // равно Ли Имя для Rasa
//    public function isNameEqual(string $name): bool
//    {
//        return $this->name === $name;
//    }
//
//    public function addRasa(RasaId $id, string $name, string $title): void
//    {
//        foreach ($this->rasas as $rasa) {
//            if ($rasa->isNameEqual($name)) {
//                throw new \DomainException('Rasa already exists.');
//            }
//        }
//        $this->rasas->add(new Linia($this, $id, $name, $title));
//    }
//
//	///////////////////////
    public function addLinia(LiniaId $id, 
                                string $name, 
                                string $nameStar, 
                                string $title,
								int $sortLinia): void
    {
        foreach ($this->linias as $linia) {
            if ($linia->isNameStarEqual($nameStar)) {
                throw new \DomainException('Линия уже существует. Попробуйте для
                этой линии добавить свой номер');
            }
        }

        $this->linias->add(new Linia($this, 
									$id, 
									$name, 
									$nameStar, 
									$title,
									$sortLinia));
    }

    public function editLinia(LiniaId $id, 
                                string $name, 
                                string $nameStar,
                                string $title
                                ): void
    {
        foreach ($this->linias as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name, $nameStar, $title );
                return;
            }
        }
        throw new \DomainException('Linia is not found.');
    }

    public function removeLinia(LiniaId $id): void
    {
        foreach ($this->linias as $linia) {
            if ($linia->getId()->isEqual($id)) {
                $this->linias->removeElement($linia);
                return;
            }
        }
        throw new \DomainException('Linia is not found.');
    }
	
	 public function getLinias()
    {
        return $this->linias->toArray();
    }

    
    public function getLinia(LiniaId $id): Linia
    {
        foreach ($this->linias as $linia) {
            if ($linia->getId()->isEqual($id)) {
                return $linia;
            }
        }
        throw new \DomainException('Linia is not found.');
    }
///////////////////////////////////////
    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
	
	public function getTitle(): string
    {
        return $this->title;
    }
}

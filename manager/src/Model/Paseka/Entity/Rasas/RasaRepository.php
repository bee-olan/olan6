<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Rasas;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class RasaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Rasa::class);
        $this->em = $em;
    }

    public function get(Id $id): Rasa
    {
        /** @var Rasa $rasa */
        if (!$rasa = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Rasa is not found.');
        }
        return $rasa;
    }

    public function add(Rasa $rasa): void
    {
        $this->em->persist($rasa);
    }

    public function remove(Rasa $rasa): void
    {
        $this->em->remove($rasa);
    }
}

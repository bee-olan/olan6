<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\PlemMatka;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class PlemMatkaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(PlemMatka::class);
        $this->em = $em;
    }

    public function get(Id $id): PlemMatka
    {
        /** @var PlemMatka $plemmatka */
        if (!$plemmatka = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('PlemMatka is not found.');
        }
        return $plemmatka;
    }

    public function add(PlemMatka $plemmatka): void
    {
        $this->em->persist($plemmatka);
    }

    public function remove(PlemMatka $plemmatka): void
    {
        $this->em->remove($plemmatka);
    }
}

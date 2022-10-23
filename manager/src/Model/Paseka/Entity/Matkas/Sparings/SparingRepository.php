<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\Sparings;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class SparingRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Sparing::class);
        $this->em = $em;
    }

    public function get(Id $id): Sparing
    {
        /** @var Sparings $sparings */
        if (!$sparing = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Sparing is not found.');
        }
        return $sparing;
    }

    public function add(Sparing $sparing): void
    {
        $this->em->persist($sparing);
    }

    public function remove(Sparing $sparing): void
    {
        $this->em->remove($sparing);
    }
}

<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Nachalos;

use App\Model\Paseka\Entity\Sezons\Godas\Id as GodaId;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class NachaloRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Nachalo::class);
        $this->em = $em;
    }

    public function has(Id $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasByGoda(GodaId $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.goda = :goda')
                ->setParameter(':goda', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): Nachalo
    {
        /** @var Nachalo $nachalo */
        if (!$nachalo = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Nachalo is not found.');
        }
        return $nachalo;
    }

    public function add(Nachalo $nachalo): void
    {
        $this->em->persist($nachalo);
    }
}

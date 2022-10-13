<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Rasas\Linias\Nomers;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class NomerRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Nomer::class);
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

    public function get(Id $id): Nomer
    {
        /** @var Nomer $nomer */
        if (!$nomer = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Nomer is not found.');
        }
        return $nomer;
    }

    public function add(Nomer $nomer): void
    {
        $this->em->persist($nomer);
    }
}

<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Rasas\Linias;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class LiniaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Linia::class);
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

    public function get(Id $id): Linia
    {
        /** @var Linia $linia */
        if (!$linia = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Linia is not found.');
        }
        return $linia;
    }

    public function add(Linia $linia): void
    {
        $this->em->persist($linia);
    }
}

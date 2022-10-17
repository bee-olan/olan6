<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Uchasties\Uchastie;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class UchastieRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Uchastie::class);
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

    public function get(Id $id): Uchastie
    {
        /** @var Uchastie $uchastie */
        if (!$uchastie = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Uchastie is not found.');
        }
        return $uchastie;
    }

    public function add(Uchastie $uchastie): void
    {

        $this->em->persist($uchastie);
    }
}

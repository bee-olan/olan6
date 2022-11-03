<?php

declare(strict_types=1);

namespace App\Model\Sezons\Entity\Sezon;

use App\Model\EntityNotFoundException;

use Doctrine\ORM\EntityManagerInterface;

class SezonRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Sezon::class);
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


    public function get(Id $id): Sezon
    {
        /** @var Sezon $sezon */
        if (!$sezon = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Нет такого сезона.');
        }
        return $sezon;
    }

    public function add(Sezon $sezon): void
    {

        $this->em->persist($sezon);
    }
}

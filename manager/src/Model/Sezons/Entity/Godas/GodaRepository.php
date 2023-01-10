<?php

declare(strict_types=1);

namespace App\Model\Sezons\Entity\Godas;

use App\Model\EntityNotFoundException;

use Doctrine\ORM\EntityManagerInterface;

class GodaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Goda::class);
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


    public function get(Id $id): Goda
    {
        /** @var Goda $goda */
        if (!$goda = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Нет такого сезона.');
        }
        return $goda;
    }

    public function add(Goda $goda): void
    {

        $this->em->persist($goda);
    }
}

<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Tochkas\TochkaMatkas;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class TochkaMatkaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(TochkaMatka::class);
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

    public function get(Id $id): TochkaMatka
    {
        /** @var TochkaMatka $tochmatka */
        if (!$tochmatka = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('TochkaMatka is not found.');
        }
        return $tochmatka;
    }

    public function add(TochkaMatka $tochmatka): void
    {
        $this->em->persist($tochmatka);
    }

    public function remove(TochkaMatka $tochmatka): void
    {
        $this->em->remove($tochmatka);
    }
}

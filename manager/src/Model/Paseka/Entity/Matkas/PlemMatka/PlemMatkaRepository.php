<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\PlemMatka;

use App\Model\Paseka\Entity\Matkas\Role\Id as RoleId;
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

    public function hasUchastiesWithRole(RoleId $id): bool
    {
        return $this->repo->createQueryBuilder('p')
                ->select('COUNT(p.id)')
                ->innerJoin('p.uchastniks', 'ms')
                ->innerJoin('ms.roles', 'r')
                ->andWhere('r.id = :role')
                ->setParameter(':role', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

//    public function hasUchastiesWithKatigoria(KatigoriaId $id): bool
//    {
//        return $this->repo->createQueryBuilder('p')
//                ->select('COUNT(p.id)')
//                ->innerJoin('p.uchastniks', 'ms')
//                ->innerJoin('ms.roles', 'r')
//                ->andWhere('r.id = :role')
//                ->setParameter(':role', $id->getValue())
//                ->getQuery()->getSingleScalarResult() > 0;
//    }

    public function get(Id $id): PlemMatka
    {
        /** @var PlemMatka $plemmatka */
        if (!$plemmatka = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('plemmatka is not found.');
        }
        return $plemmatka;
    }

    // public function get(Id $id): PlemMatka
    // {
    //     /** @var PlemMatka $plemmatka */
    //     if (!$plemmatka = $this->repo->find($id->getValue())) {
    //         throw new EntityNotFoundException('PlemMatka is not found.');
    //     }
    //     return $plemmatka;
    // }

    public function hasBySort(int $sort): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.sort = :sort')
                ->setParameter(':sort', $sort)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasSortPerson(int $sort, int $persona): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.sort = :sort')
                ->setParameter(':sort', $sort)
                ->andWhere('t.persona = :persona')
                ->setParameter(':persona', $persona)
                ->getQuery()->getSingleScalarResult() > 0;
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

<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Tochkas;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class TochkaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Tochka::class);
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

    public function get(Id $id): Tochka
    {
        /** @var Tochka $tochka */
        if (!$tochka = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Tochka is not found.');
        }
        return $tochka;
   }

//    public function get(string $id): Tochka
//    {
//        /** @var Tochka $tochka */
//        if (!$tochka = $this->repo->find($id)) {
//            throw new EntityNotFoundException('Tochka is not found.');
//        }
//        return $tochka;
//    }

    public function add(Tochka $tochka): void
    {
        $this->em->persist($tochka);
    }

    public function remove(Tochka $tochka): void
    {
        $this->em->remove($tochka);
    }
}

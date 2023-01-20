<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Godas;

use App\Model\EntityNotFoundException;
use App\ReadModel\NotFoundException;
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


    public function get(Id $id): Goda
    {
        /** @var Goda $goda */
        if (!$goda = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Нет такого сезона.');
        }
        return $goda;
    }
//    public function get(string $id): Goda
//    {
//        if (!$goda = $this->repo->find($id)) {
//            throw new NotFoundException('User is not found');
//        }
//        return $goda;
//    }

    public function getUchas(string $id): UchasGoda
    {
        /** @var UchasGoda $uchasgoda */
        if (!$uchasgoda = $this->repo->find($id)) {
            throw new EntityNotFoundException('Нет такого сезона!!!!!!!!!!.');
        }
        return $uchasgoda;
    }

    public function remove(Goda $goda): void
    {
        $this->em->remove($goda);
    }

    public function add(Goda $goda): void
    {
        $this->em->persist($goda);
    }
}

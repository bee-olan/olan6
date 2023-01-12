<?php

declare(strict_types=1);

namespace App\Model\Sezons\Entity\Godas\Wzatoks;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class WzatokRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Wzatok::class);
        $this->em = $em;
    }

    public function getByGodUchastie(string $content): Wzatok
    {
//        if (!$user = $this->repo->findOneBy(['email' => $email->getValue()])) {
        /** @var Wzatok $wzatok */
        if (!$wzatok = $this->repo->findOneBy(['content' => $content])) {
            throw new EntityNotFoundException('$wzatok is not found.');
        }
        return $wzatok;
    }

    public function get(Id $id): Wzatok
    {
        /** @var Wzatok $wzatok */
        if (!$wzatok = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Wzatok is not found.');
        }
        return $wzatok;
    }

    public function add(Wzatok $wzatok): void
    {
        $this->em->persist($wzatok);
    }

    public function remove(Wzatok $wzatok): void
    {
        $this->em->remove($wzatok);
    }
}

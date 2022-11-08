<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class ChildMatkaRepository
{
    private $repo;
    private $connection;
    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(ChildMatka::class);
        $this->connection = $em->getConnection();
        $this->em = $em;
    }

    /**
     * @param Id $id
     * @return ChildMatka[]
     */
    public function allByParent(Id $id): array
    {
        return $this->repo->findBy(['parent' => $id->getValue()]);
    }

    public function get(Id $id): ChildMatka
    {
        /** @var ChildMatka $childmatka */
        if (!$childmatka = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('ChildMatka is not found.');
        }
        return $childmatka;
    }

    public function add(ChildMatka $childmatka): void
    {
        $this->em->persist($childmatka);
    }

    public function remove(ChildMatka $childmatka): void
    {
        $this->em->remove($childmatka);
    }

    public function nextId(): Id
    {
        return new Id((int)$this->connection->query('SELECT nextval(\'paseka_matkas_childmatkas_seq\')')->fetchColumn());
    }
}

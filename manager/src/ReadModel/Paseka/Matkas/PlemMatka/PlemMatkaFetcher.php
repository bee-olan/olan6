<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Matkas\PlemMatka;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;

use Doctrine\DBAL\FetchMode;
use App\ReadModel\Paseka\Matkas\PlemMatka\Filter\Filter;
use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class PlemMatkaFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, 
                                PaginatorInterface $paginator, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
        $this->repository = $em->getRepository(PlemMatka::class);
    }

    public function find(string $id): ?PlemMatka
    {
        return $this->repository->find($id);
    }

    public function findIdByPlemMatka(string $name): ?IdView
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'

            )
            ->from('paseka_matkas_plemmatkas')
            ->where('name = :name')
            ->setParameter(':name', $name)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, IdView::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }


    public function getMaxSortPerson(int $persona): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(p.sort) AS m')
            ->from('paseka_matkas_plemmatkas', 'p')
            ->andWhere('persona = :personas')
            ->setParameter(':personas', $persona)
            ->execute()->fetch()['m'];
    }

    public function allList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('paseka_matkas_plemmatkas')
            ->orderBy('sort')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function existsPerson(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('paseka_uchasties_personas')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }

    public function existsMesto(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('mesto_mestonomers')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }

    public function exists(int $sort): bool
    {
       // dd($sort);
        return $this->connection->createQueryBuilder()
                ->select('COUNT (sort)')
                ->from('paseka_matkas_plemmatkas')
                ->where('sort = :sort')
                ->setParameter(':sort', $sort)
                ->execute()->fetchColumn() > 0;
    }

//    public function infaSparing(string $sparingId): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                's.title ',
//                's.name'
//            )
//            ->from('paseka_matkas_sparings', 's')
//            //->innerJoin('p', 'paseka_uchasties_uchasties', 'u', 'p.id = u.id')
//            ->andWhere('s.id = :sparingId')
//            ->setParameter(':sparingId', $sparingId)
//            // ->orderBy('p.sort')->addOrderBy('d.name')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }

    public function infaRasaNom(string $rasaNomId): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'n.name_star AS nomer',
                'n.name AS nomer_n',
                'l.name_star AS linia',
                'l.name AS linia_n',
                'r.title AS rasa',
                'r.name AS name'
            )
            ->from('paseka_rasa_linia_nomers', 'n')
            ->innerJoin('n', 'paseka_rasa_linias', 'l', 'n.linia_id = l.id')
            ->innerJoin('l', 'paseka_rasas', 'r', 'l.rasa_id = r.id')
            ->andWhere('n.id = :rasaNomId')
            ->setParameter(':rasaNomId', $rasaNomId)
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }


    public function infaMesto(string $mesto): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'r.name AS raion',
                'ob.name AS oblast',
                'ok.name AS okrug'
            )
            ->from('mesto_okrug_oblast_raions', 'r')
            ->innerJoin('r', 'mesto_okrug_oblasts', 'ob', 'r.oblast_id = ob.id')
            ->innerJoin('ob', 'mesto_okrugs', 'ok', 'ob.okrug_id = ok.id')

            ->andWhere('r.mesto = :mesto')
            ->setParameter(':mesto', $mesto)
           // ->orderBy('p.sort')->addOrderBy('d.name')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    /**
     * @param Filter $filter
     * @param int $page
     * @param int $size
     * @param string $sort
     * @param string $direction
     * @return PaginationInterface
     */
    public function all(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'p.id',
                'p.name',
                'p.persona',
                'p.status',
                'p.rasa_nom_id',
                'p.goda_vixod ',
                's.name AS kategoria'
                //,
              //  'm.nomer as mestonomer'
            )
            ->from('paseka_matkas_plemmatkas', 'p')
            ->innerJoin('p', 'paseka_matkas_kategorias', 's', 'p.kategoria_id = s.id')
        ;

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('p.name', ':name'));
            $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

        if ($filter->status) {
            $qb->andWhere('p.status = :status');
            $qb->setParameter(':status', $filter->status);
        }
//
//        if ($filter->kategoria) {
//            $qb->andWhere('p.kategoria = :kategoria');
//            $qb->setParameter(':kategoria', $filter->kategoria);
//        }

        if ($filter->persona) {
            $qb->andWhere('p.persona = :persona');
            $qb->setParameter(':persona', $filter->persona);
        }

        if (!\in_array($sort, ['name', 'status','persona'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }
}

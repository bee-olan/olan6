<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Matkas\PlemMatka;

use Doctrine\DBAL\FetchMode;
use App\ReadModel\Paseka\Matkas\PlemMatka\Filter\Filter;
use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class PlemMatkaFetcher
{
    private $connection;
    private $paginator;

    public function __construct(Connection $connection, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
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

//    public function infaPersona(int $persona): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'u.name_nike AS nike'
//            )
//            ->from('paseka_uchasties_personas', 'p')
//            ->innerJoin('p', 'paseka_uchasties_uchasties', 'u', 'p.id = u.id')
//            ->andWhere('p.nomer = :persona')
//            ->setParameter(':persona', $persona)
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
                'l.name_star AS linia',
                'r.title AS rasa'
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
                'p.rasa_nom_id'
                //,
              //  'm.nomer as mestonomer'
            )
            ->from('paseka_matkas_plemmatkas', 'p')
           // ->innerJoin('p', 'mesto_mestonomers', 'm', 'p.id = m.id')
        ;

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('p.name', ':name'));
            $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

        if ($filter->status) {
            $qb->andWhere('p.status = :status');
            $qb->setParameter(':status', $filter->status);
        }
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

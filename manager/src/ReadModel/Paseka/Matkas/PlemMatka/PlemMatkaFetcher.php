<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Matkas\PlemMatka;


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

    public function getMaxSort(): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(p.sort) AS m')
            ->from('paseka_matkas_plemmatkas', 'p')
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
                'p.status'
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

        if (!\in_array($sort, ['name', 'status'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }
}

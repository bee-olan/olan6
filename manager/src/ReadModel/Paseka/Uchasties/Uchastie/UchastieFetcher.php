<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Uchasties\Uchastie;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Status;
use App\ReadModel\Paseka\Uchasties\Uchastie\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class UchastieFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(Uchastie::class);
        $this->paginator = $paginator;
    }

    public function find(string $id): ?Uchastie
    {
        return $this->repository->find($id);
    }

//    public function findUchasOfChildMat(string $rasaNomId): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'n.name_star AS nomer',
//                'n.name AS nomer_n',
//                'l.name_star AS linia',
//                'l.name AS linia_n',
//                'r.title AS rasa',
//                'r.name AS name'
//            )
//            ->from('paseka_rasa_linia_nomers', 'n')
//            ->innerJoin('n', 'paseka_rasa_linias', 'l', 'n.linia_id = l.id')
//            ->innerJoin('l', 'paseka_rasas', 'r', 'l.rasa_id = r.id')
//            ->andWhere('n.id = :rasaNomId')
//            ->setParameter(':rasaNomId', $rasaNomId)
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }


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
                'm.id',
                'TRIM(CONCAT(m.name_first, \' \', m.name_last, \' \', m.name_nike)) AS name',
                 'm.email',
                'g.name as group',
                'uchkak',
                 'm.status',
                '(SELECT COUNT(*) FROM paseka_matkas_plemmatka_uchastniks ms WHERE ms.uchastie_id = m.id) as uchastniks_count',
                '(SELECT COUNT(*) FROM paseka_sezons_uchasgodas ug WHERE ug.uchastie_id = m.id) as uchasgodas_count'
            )
            ->from('paseka_uchasties_uchasties', 'm')
            ->innerJoin('m', 'paseka_uchasties_groups', 'g', 'm.group_id = g.id');
           // ->innerJoin('m', 'paseka_uchasties_personas', 'p', 'm.id = p.id');

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(CONCAT(m.name_first, \' \', m.name_last, \' \', m.name_mike))', ':name'));
            $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

        if ($filter->email) {
            $qb->andWhere($qb->expr()->like('LOWER(m.email)', ':email'));
            $qb->setParameter(':email', '%' . mb_strtolower($filter->email) . '%');
        }

         if ($filter->status) {
             $qb->andWhere('m.status = :status');
             $qb->setParameter(':status', $filter->status);
         }

        if ($filter->group) {
            $qb->andWhere('m.group_id = :group');
            $qb->setParameter(':group', $filter->group);
        }

        if ($filter->uchkak) {
            $qb->andWhere('uchkak = :uchkak');
            $qb->setParameter(':uchkak', $filter->uchkak);
        }

        if (!\in_array($sort, ['name', 'uchkak', 'group'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }

    public function exists(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('paseka_uchasties_uchasties')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }


    
    public function activeGroupedList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select([
                'm.id',
                'CONCAT(m.name_first, \' \', m.name_last, \' \', m.name_nike) AS name',
                'g.name AS group'
            ])
            ->from('paseka_uchasties_uchasties', 'm')
            ->leftJoin('m', 'paseka_uchasties_groups', 'g', 'g.id = m.group_id')
             ->andWhere('m.status = :status')
             ->setParameter(':status', Status::ACTIVE)
            ->orderBy('g.name')->addOrderBy('name')
            ->execute();
        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function activeDepartmentListForPlemMatka(string $plemmatka): array
    {

        $stmt = $this->connection->createQueryBuilder()
            ->select([
                'm.id',
                'CONCAT(m.name_first, \' \', m.name_last) AS name'
                //,
                //'d.name AS department'
            ])
            ->from('paseka_uchasties_uchasties', 'm')
//            ->innerJoin('m', 'work_projects_project_memberships', 'ms', 'ms.member_id = m.id')
//            ->innerJoin('ms', 'work_projects_project_membership_departments', 'msd', 'msd.membership_id = ms.id')
//            ->innerJoin('msd', 'work_projects_project_departments', 'd', 'd.id = msd.department_id')
//            ->andWhere('m.status = :status AND ms.project_id = :project')
//            ->setParameter(':status', Status::ACTIVE)
//            ->setParameter(':project', $project)
            // ->orderBy('d.name')->addOrderBy('name')
            ->execute();
        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }


}

<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Matkas\Actions;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Query\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;

class ActionFetcher
{
    private $connection;
    private $paginator;

    public function __construct(Connection $connection, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
    }

    public function all(Filter $filter, int $page, int $size): PaginationInterface
    {
        $qb = $this->createQb();

        if ($filter->member) {
            $qb->innerJoin('project', 'work_projects_project_memberships', 'membership', 'project.id = membership.project_id');
            $qb->andWhere('membership.member_id = :member');
            $qb->setParameter(':member', $filter->member);
        }

        if ($filter->project) {
            $qb->andWhere('project.id = :project_id OR set_project.id = :project_id');
            $qb->setParameter(':project_id', $filter->project);
        }

        $qb->orderBy('c.date', 'desc');

        return $this->paginator->paginate($qb, $page, $size);
    }

    public function allForTask(int $id): array
    {
        $stmt = $this->createQb()
            ->andWhere('task.id = :task_id')
            ->setParameter(':task_id', (string)$id)
            ->orderBy('c.date', 'asc')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    private function createQb(): QueryBuilder
    {
        return $this->connection->createQueryBuilder()
            ->select(
                'c.*',
                'task.name AS task_name',
                'TRIM(CONCAT(actor.name_first, \' \', actor.name_last)) AS actor_name',
                'project.id AS project_id',
                'project.name AS project_name',
                'TRIM(CONCAT(set_executor.name_first, \' \', set_executor.name_last)) AS set_executor_name',
                'TRIM(CONCAT(set_revoked_executor.name_first, \' \', set_revoked_executor.name_last)) AS set_revoked_executor_name',
                'set_project.name AS set_project_name'
            )
            ->from('paseka_matkas_child_changes', 'c')
            ->leftJoin('c', 'paseka_uchasties_uchasties', 'actor', 'c.actor_id = actor.id')
            ->leftJoin('c', 'paseka_uchasties_uchasties', 'set_executor', 'c.set_executor_id = set_executor.id')
            ->leftJoin('c', 'paseka_uchasties_uchasties', 'set_revoked_executor', 'c.set_revoked_executor_id = set_executor.id')
            ->leftJoin('c', 'paseka_matkas_childmatkas', 'task', 'c.task_id = task.id')
            ->leftJoin('task', 'paseka_matkas_plemmatkas', 'project', 'task.project_id = project.id')
            ->leftJoin('c', 'paseka_matkas_plemmatkas', 'set_project', 'c.set_project_id = set_project.id');
    }



//    public function allForChildMatka(int $id): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'c.*',
//                'TRIM(CONCAT(actor.name_first, \' \', actor.name_last)) AS actor_name',
//                'TRIM(CONCAT(set_executor.name_first, \' \', set_executor.name_last)) AS set_executor_name',
//                'TRIM(CONCAT(set_revoked_executor.name_first, \' \', set_revoked_executor.name_last)) AS set_revoked_executor_name',
//                'set_plemmatka.name AS set_plemmatka_name'
//            )
//            ->from('paseka_matkas_child_changes', 'c')
//            ->leftJoin('c', 'paseka_uchasties_uchasties', 'actor', 'c.actor_id = actor.id')
//            ->leftJoin('c', 'paseka_uchasties_uchasties', 'set_executor', 'c.set_executor_id = set_executor.id')
//            ->leftJoin('c', 'paseka_uchasties_uchasties', 'set_revoked_executor', 'c.set_revoked_executor_id = set_executor.id')
//            ->leftJoin('c', 'paseka_matkas_childmatkas', 'childmatka', 'c.childmatka_id = childmatka.id')
//            ->leftJoin('c', 'paseka_matkas_plemmatkas', 'set_plemmatka', 'c.set_plemmatka_id = set_plemmatka.id')
//            ->andWhere('childmatka.id = :childmatka_id')
//            ->setParameter(':childmatka_id', $id)
//            ->orderBy('c.date', 'asc')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }
}

<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Matkas\ChildMatka;

use App\ReadModel\Paseka\Matkas\ChildMatka\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;

class ChildMatkaFetcher
{
    private $connection;
    private $paginator;

    public function __construct(Connection $connection, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
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
                't.id',
                't.date',
                't.author_id',
                'm.name_nike AS  author_name',
                't.plemmatka_id',
                'p.name plemmatka_name',
                't.name',
                't.parent_id AS parent',
                't.type',
                't.priority',
                't.progress',
                't.plan_date',
                't.status',
                'r.nomer AS mesto',
                'u.nomer AS  author_persona'
            )
            ->from('paseka_matkas_childmatkas', 't')
            ->innerJoin('t', 'paseka_uchasties_uchasties', 'm', 't.author_id = m.id')
            ->innerJoin('t', 'paseka_matkas_plemmatkas', 'p', 't.plemmatka_id = p.id')
            ->innerJoin('t', 'mesto_mestonomers', 'r', 't.author_id = r.id')
            ->innerJoin('t', 'paseka_uchasties_personas', 'u', 't.author_id = u.id')
        ;

        // if ($filter->member) {
        //     $qb->innerJoin('t', 'work_projects_project_memberships', 'ms', 't.project_id = ms.project_id');
        //     $qb->andWhere('ms.member_id = :member');
        //     $qb->setParameter(':member', $filter->member);
        // }

        if ($filter->plemmatka) {
            $qb->andWhere('t.plemmatka_id = :plemmatka');
            $qb->setParameter(':plemmatka', $filter->plemmatka);
        }

//        if ($filter->author) {
//            $qb->andWhere('t.author_id = :author');
//            $qb->setParameter(':author', $filter->author);
//        }

         if ($filter->name) {
             $qb->andWhere($qb->expr()->like('LOWER(t.name)', ':name'));
             $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
         }

        if ($filter->type) {
            $qb->andWhere('t.type = :type');
            $qb->setParameter(':type', $filter->type);
        }

        if ($filter->priority) {
            $qb->andWhere('t.priority = :priority');
            $qb->setParameter(':priority', $filter->priority);
        }

        if ($filter->status) {
            $qb->andWhere('t.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

         if ($filter->executor) {
             $qb->innerJoin('t', 'paseka_matkas_childmatkas_executors', 'e', 'e.childmatka_id = t.id');
             $qb->andWhere('e.uchastie_id = :executor');
             $qb->setParameter(':executor', $filter->executor);
         }
       // , 'author_name'
        if (!\in_array($sort, ['t.id', 't.date', 'plemmatka_name', 'name', 't.type', 't.plan_date', 't.progress', 't.priority', 't.status'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        /** @var SlidingPagination $pagination */
        $pagination = $this->paginator->paginate($qb, $page, $size);

        $childmatkas = $pagination->getItems();
        $executors = $this->batchLoadExecutors(array_column($childmatkas, 'id'));

        $pagination->setItems(array_map(static function (array $childmatka) use ($executors) {
            return array_merge($childmatka, [
                'executors' => array_filter($executors, static function (array $executor) use ($childmatka) {
                    return $executor['childmatka_id'] === $childmatka['id'];
                }),
            ]);
        }, $childmatkas));

        return $pagination;
    }

    // public function childrenOf(int $task): array
    // {
    //     $stmt = $this
    //         ->connection->createQueryBuilder()
    //         ->select(
    //             't.id',
    //             't.date',
    //             't.project_id',
    //             'p.name project_name',
    //             't.name',
    //             't.parent_id AS parent',
    //             't.type',
    //             't.priority',
    //             't.progress',
    //             't.plan_date',
    //             't.status'
    //         )
    //         ->from('work_projects_tasks', 't')
    //         ->innerJoin('t', 'work_projects_projects', 'p', 't.project_id = p.id')
    //         ->andWhere('t.parent_id = :parent')
    //         ->setParameter(':parent', $task)
    //         ->orderBy('date', 'desc')
    //         ->execute();

    //     $tasks = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    //     $executors = $this->batchLoadExecutors(array_column($tasks, 'id'));

    //     return array_map(static function (array $task) use ($executors) {
    //         return array_merge($task, [
    //             'executors' => array_filter($executors, static function (array $executor) use ($task) {
    //                 return $executor['task_id'] === $task['id'];
    //             }),
    //         ]);
    //     }, $tasks);
    // }

     private function batchLoadExecutors(array $ids): array
     {
         $stmt = $this->connection->createQueryBuilder()
             ->select(
                 'e.childmatka_id',
                 'TRIM(CONCAT(m.name_first, \' \', m.name_last)) AS name'
             )
             ->from('paseka_matkas_childmatkas_executors', 'e')
             ->innerJoin('e', 'paseka_uchasties_uchasties', 'm', 'm.id = e.uchastie_id')
             ->andWhere('e.childmatka_id IN (:childmatka)')
             ->setParameter(':childmatka', $ids, Connection::PARAM_INT_ARRAY)
             ->orderBy('name')
             ->execute();

         return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
     }
}

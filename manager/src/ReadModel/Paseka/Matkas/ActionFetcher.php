<?php

declare(strict_types=1);
namespace App\ReadModel\Paseka\Matkas;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class ActionFetcher

{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function allForChildMatka(int $id): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'c.*',
                'TRIM(CONCAT(actor.name_first, \' \', actor.name_last)) AS actor_name',
                'TRIM(CONCAT(set_executor.name_first, \' \', set_executor.name_last)) AS set_executor_name',
                'TRIM(CONCAT(set_revoked_executor.name_first, \' \', set_revoked_executor.name_last)) AS set_revoked_executor_name',
                'set_plemmatka.name AS set_plemmatka_name'
            )
            ->from('paseka_matkas_child_changes', 'c')
            ->leftJoin('c', 'paseka_uchasties_uchasties', 'actor', 'c.actor_id = actor.id')
            ->leftJoin('c', 'paseka_uchasties_uchasties', 'set_executor', 'c.set_executor_id = set_executor.id')
            ->leftJoin('c', 'paseka_uchasties_uchasties', 'set_revoked_executor', 'c.set_revoked_executor_id = set_executor.id')
            ->leftJoin('c', 'paseka_matkas_childmatkas', 'childmatka', 'c.childmatka_id = childmatka.id')
            ->leftJoin('c', 'paseka_matkas_plemmatkas', 'set_plemmatka', 'c.set_plemmatka_id = set_plemmatka.id')
            ->andWhere('childmatka.id = :childmatka_id')
            ->setParameter(':childmatka_id', $id)
            ->orderBy('c.date', 'asc')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}

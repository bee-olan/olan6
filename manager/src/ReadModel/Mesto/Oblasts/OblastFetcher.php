<?php

declare(strict_types=1);

namespace App\ReadModel\Mesto\Oblasts;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class OblastFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function listOfOkrug(string $okrug): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name',
                'nomer',
                'mesto'
            )
            ->from('rabota_u4astniki_mesto_oblasts')
            ->andWhere('okrug_id = :okrug')
            ->setParameter(':okrug', $okrug)
            ->orderBy('name')
            ->orderBy('nomer')
            ->orderBy('mesto')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function allOfOkrug(string $okrug): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.name',
                'd.nomer',
                'd.mesto'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :okrug
                // ) AS members_count'
            )
            ->from('rabota_u4astniki_mesto_oblasts', 'd')
            ->andWhere('okrug_id = :okrug')
            ->setParameter(':okrug', $okrug)
            ->orderBy('name')
            ->orderBy('nomer')
            ->orderBy('mesto')
            ->execute();
//dd($stmt->fetchAll(FetchMode::ASSOCIATIVE));
            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
}

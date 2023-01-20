<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Sezons\Tochkas;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class TochkaFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getMaxTochka(string $uchasgoda): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(p.tochka) AS m')
            ->from('paseka_sezon_tochkas', 'p')
            ->andWhere('uchasgoda_id = :uchasgodas')
            ->setParameter(':uchasgodas', $uchasgoda)
            ->execute()->fetch()['m'];
    }

    public function assoc(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'gruppa'
            )
            ->from('paseka_sezon_tochkas')
            ->orderBy('gruppa')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }


    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                't.id',
                't.uchasgoda_id',
                't.kolwz',
                't.gruppa',
                't.name'
//                '(SELECT COUNT(*) FROM paseka_sezons_uchasgodas ug WHERE ug.goda_id = t.id) as uchasgoda_count'
            // ,
            // '(SELECT COUNT(*) FROM sait_u4astniks_u4astniks m WHERE m.godd_id = g.id) AS u4astniks'
            )
            ->from('paseka_sezon_tochkas', 't')
//            ->innerJoin('s', 'work_members_groups', 'g', 'm.group_id = g.id');
            ->orderBy('gruppa')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

//    public function allTochok(string ): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                't.id',
//                't.uchasgoda_id',
//                't.kolwz',
//                't.gruppa'
////                '(SELECT COUNT(*) FROM paseka_sezons_uchasgodas ug WHERE ug.goda_id = t.id) as uchasgoda_count'
//            // ,
//            // '(SELECT COUNT(*) FROM sait_u4astniks_u4astniks m WHERE m.godd_id = g.id) AS u4astniks'
//            )
//            ->from('paseka_sezon_tochkas', 't')
////            ->innerJoin('s', 'work_members_groups', 'g', 'm.group_id = g.id');
//            ->orderBy('gruppa')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }

}
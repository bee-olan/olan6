<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Sezons\Tochkas\Wzatoks;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class WzatokFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
//    public function assoc(): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'id',
//                'gruppa'
//            )
//            ->from('paseka_sezon_tochkas')
//            ->orderBy('gruppa')
//            ->execute();
//
//        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
//    }
    public function getMaxWzatok(string $tochka): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(w.nomerwz) AS m')
            ->from('paseka_sezon_tochka_wzatoks', 'w')
            ->andWhere('tochka_id = :tochkas')
            ->setParameter(':tochkas', $tochka)
            ->execute()->fetch()['m'];
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'w.id',
                'w.tochka_id',
                'w.start_date',
                'w.pobelka_date',
                'w.end_date',
                'w.rasstojan',
                'w.nomerwz',
                'w.gruppa'
//                '(SELECT COUNT(*) FROM paseka_sezons_uchasgodas ug WHERE ug.goda_id = t.id) as uchasgoda_count'
            // ,
            // '(SELECT COUNT(*) FROM sait_u4astniks_u4astniks m WHERE m.godd_id = g.id) AS u4astniks'
            )
            ->from('paseka_sezon_tochka_wzatoks', 'w')
//            ->innerJoin('s', 'work_members_groups', 'g', 'm.group_id = g.id');
            ->orderBy('gruppa')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function allOfTochka(string $tochka): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'w.id',
                'w.tochka_id',
                'w.start_date as start',
                'w.pobelka_date as pobelka',
                'w.end_date as end',
                'w.rasstojan',
                'w.nomerwz',
                'w.gruppa'
//                '(SELECT COUNT(*) FROM paseka_sezons_uchasgodas ug WHERE ug.goda_id = t.id) as uchasgoda_count'
            )
            ->from('paseka_sezon_tochka_wzatoks', 'w')
            ->andWhere('w.tochka_id = :tochkas')
            ->setParameter(':tochkas', $tochka)
//            ->innerJoin('s', 'work_members_groups', 'g', 'm.group_id = g.id');
            ->orderBy('gruppa')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}
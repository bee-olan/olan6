<?php

declare(strict_types=1);

namespace App\ReadModel\Sezons\Godas\Wzatoks;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class WzatokFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function assoc(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'gruppa'
            )
            ->from('sezon_goda_wzatoks')
            ->orderBy('gruppa')
            ->execute();

            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function allOfGoda(string $goda): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'w.id',
                'w.goda_id AS goda',
                'w.content',
                'w.kolwz',
                'w.gruppa',
                'w.uchastie_id'
//                '(SELECT COUNT(*) FROM paseka_goda_linia_nomers n WHERE n.linia_id = w.id) AS nomers'
            // '(
            //     SELECT COUNT(ms.member_id)
            //     FROM work_projects_project_memberships ms
            //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
            //     WHERE md.department_id = d.id AND ms.materi_id = :materi
            // ) AS members_count'
            )
            ->from('sezon_goda_wzatoks', 'w')
            ->andWhere('w.goda_id = :godas')
            ->setParameter(':godas', $goda)
            ->orderBy('gruppa')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                's.id',
                's.content',
                's.kolwz',
                's.gruppa',
                's.uchastie_id'


//                '(SELECT COUNT(*) FROM paseka_goda_linias l WHERE w.goda_id = s.id) AS linias'
            )
            ->from('sezon_goda_wzatoks', 's')
            ->orderBy('gruppa')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function allSezSxem(string $god): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                's.id',
                's.content',
                's.kolwz',
                's.gruppa',
                's.uchastie_id',
                's.god'

//                '(SELECT COUNT(*) FROM paseka_goda_linias l WHERE l.goda_id = s.id) AS linias'
            )
            ->from('sezon_goda_wzatoks', 's')
            ->andWhere('s.god = :gods')
            ->setParameter(':gods', $god)
            ->orderBy('gruppa')

            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
//    public function allRasaLin(): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'r.id',
//                'r.name',
//                'r.title',
//                'l.sort_linia as sort_linia',
//                'l.name_star as linias',
//                'l.id as linia_id'
//                //,
//                // '(SELECT COUNT(*) FROM paseka_goda_linias l WHERE l.goda_id = r.id) AS kol_lin'
//            )
//            ->from('sezon_goda_wzatoks', 'r')
//            ->innerJoin('r', 'paseka_goda_linias', 'l', 'l.goda_id = r.id')
//            ->orderBy('name')
//            ->orderBy('title')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }
//
//    public function allRasaLinNom(): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'r.id',
//                'r.name',
//                'r.title',
//                'l.sort_linia as sort_linia',
//                'l.name_star as linias',
//                'l.id as linia_id',
//                'n.sort_nomer as sort_nomer',
//                'n.name_star as nomers',
//                'n.id as nomer_id',
//                'n.title as nomer_title'
//            )
//            ->from('paseka_godas', 'r')
//            ->innerJoin('r', 'paseka_goda_linias', 'l', 'l.goda_id = r.id')
//            ->innerJoin('l', 'paseka_goda_linia_nomers', 'n', 'n.linia_id = l.id')
//            ->orderBy('name')
//            ->orderBy('title')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }
}

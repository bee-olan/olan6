<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Sezons\Tochkas\TochkaMatkas;

use App\Model\EntityNotFoundException;


use App\Model\Paseka\Entity\Sezons\Tochkas\TochkaMatkas\TochkaMatkaRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class TochkaMatkaFetcher
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
                'tochka_id'
            )
            ->from('paseka_sezons_tochka_tochmatkas')
            ->orderBy('tochka_id')
            ->execute();

            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }
//    public function exists(string $id, string  $goda): bool
//    {
//        return $this->connection->createQueryBuilder()
//                ->select('COUNT (id)')
//                ->from('paseka_sezons_tochka_tochmatkas')
//                ->where('uchastie_id = :id')
//                ->setParameter(':id', $id)
//                ->where('goda_id = :goda')
//                ->setParameter(':goda', $goda)
//                ->execute()->fetchColumn() > 0;
//    }

//    public function getUchas(string $id): UchasGoda
//    {
//        /** @var UchasGoda $uchasgoda */
//        if (!$uchasgoda = $this->repository->find($id)) {
//            throw new EntityNotFoundException('Нет такого сезона???!!!!!!!!!!.');
//        }
//        return $uchasgoda;
//    }

    public function allOfTochka(string $tochka): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'tm.id',
                'tm.tochka_id',
                'tm.childmatka_id',
                'c.name AS name'

//            '(SELECT COUNT(*) FROM paseka_sezon_tochka_wzatoks w WHERE w.tochka_id = t.id) AS koltochka'
            // '(
            //     SELECT COUNT(ms.member_id)
            //     FROM work_projects_project_memberships ms
            //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
            //     WHERE md.department_id = d.id AND ms.materi_id = :materi
            // ) AS members_count'
            )
            ->from('paseka_sezon_tochka_tochmatkas', 'tm')
            ->innerJoin('tm', 'paseka_matkas_childmatkas', 'c', 'c.id = tm.childmatka_id')
            ->andWhere('tm.tochka_id = :tochkas')
            ->setParameter(':tochkas', $tochka)
            ->orderBy('tm.childmatka_id')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

//    public function all(): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'u.id',
//                'u.goda_id ',
//                'u.uchastie_id',
//                'u.koltochek',
//                'u.gruppa',
//                'g.sezon as sezon',
//                't.gruppa as grtochka',
//                't.kolwz as kolwz',
//                't.name as name'
//
//
////                '(SELECT COUNT(*) FROM paseka_sezon_tochkas t WHERE t.gruppa = s.id) AS linias'
//            )
//            ->from('paseka_sezons_uchasgodas', 'u')
//            ->innerJoin('u', 'paseka_sezons_godas', 'g', 'g.id = u.goda_id')
//            ->innerJoin('u', 'paseka_sezon_tochkas', 't', 't.uchasgoda_id = u.id')
//            ->orderBy('sezon')
//            ->orderBy('grtochka')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }
//
//    public function allTochok(string $uchasgoda): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'u.id',
//                'u.goda_id ',
//                'u.uchastie_id',
//                'u.koltochek',
//                'u.gruppa',
//                'g.sezon as sezon',
//                't.gruppa as grtochka',
//                't.kolwz as kolwz',
//                't.name as name'
//
////                '(SELECT COUNT(*) FROM paseka_sezon_tochkas t WHERE t.gruppa = s.id) AS linias'
//            )
//            ->from('paseka_sezons_uchasgodas', 'u')
//            ->innerJoin('u', 'paseka_sezons_godas', 'g', 'g.id = u.goda_id')
//            ->innerJoin('u', 'paseka_sezon_tochkas', 't', 't.uchasgoda_id = u.id')
//            ->andWhere('u.id = :ids')
//            ->setParameter(':ids', $uchasgoda)
//            ->orderBy('grtochka')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }
//
////    public function allSezSxem(string $god): array
////    {
////        $stmt = $this->connection->createQueryBuilder()
////            ->select(
////                's.id',
////                's.content',
////                's.kolwz',
////                's.gruppa'
////
//////                '(SELECT COUNT(*) FROM paseka_goda_linias l WHERE l.goda_id = s.id) AS linias'
////            )
////            ->from('paseka_sezons_nachalos', 's')
////            ->andWhere('s.god = :gods')
////            ->setParameter(':gods', $god)
////            ->orderBy('gruppa')
////
////            ->execute();
////
////        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
////    }
////    public function allRasaLin(): array
////    {
////        $stmt = $this->connection->createQueryBuilder()
////            ->select(
////                'r.id',
////                'r.name',
////                'r.title',
////                'l.sort_linia as sort_linia',
////                'l.name_star as linias',
////                'l.id as linia_id'
////                //,
////                // '(SELECT COUNT(*) FROM paseka_goda_linias l WHERE l.goda_id = r.id) AS kol_lin'
////            )
////            ->from('sezon_goda_wzatoks', 'r')
////            ->innerJoin('r', 'paseka_goda_linias', 'l', 'l.goda_id = r.id')
////            ->orderBy('name')
////            ->orderBy('title')
////            ->execute();
////
////        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
////    }
////
////    public function allRasaLinNom(): array
////    {
////        $stmt = $this->connection->createQueryBuilder()
////            ->select(
////                'r.id',
////                'r.name',
////                'r.title',
////                'l.sort_linia as sort_linia',
////                'l.name_star as linias',
////                'l.id as linia_id',
////                'u.sort_nomer as sort_nomer',
////                'u.name_star as nomers',
////                'u.id as nomer_id',
////                'u.title as nomer_title'
////            )
////            ->from('paseka_godas', 'r')
////            ->innerJoin('r', 'paseka_goda_linias', 'l', 'l.goda_id = r.id')
////            ->innerJoin('l', 'paseka_goda_linia_nomers', 'n', 'u.linia_id = l.id')
////            ->orderBy('name')
////            ->orderBy('title')
////            ->execute();
////
////        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
////    }
}

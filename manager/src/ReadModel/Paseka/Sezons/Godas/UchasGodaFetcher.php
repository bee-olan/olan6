<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Sezons\Godas;

use App\Model\EntityNotFoundException;
use App\Model\Paseka\Entity\Sezons\Godas\Id;
use App\Model\Paseka\Entity\Sezons\Godas\UchasGoda;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class UchasGodaFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(UchasGoda::class);
        $this->paginator = $paginator;
    }


    public function assoc(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'gruppa'
            )
            ->from('paseka_sezons_nachalos')
            ->orderBy('gruppa')
            ->execute();

            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }
    public function exists( string  $gruppa): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('paseka_sezons_uchasgodas')

                ->where('gruppa = :gruppas')
                ->setParameter(':gruppas', $gruppa)
                ->execute()->fetchColumn() > 0;
    }

    public function getUchas(string $id): UchasGoda
    {
        /** @var UchasGoda $uchasgoda */
        if (!$uchasgoda = $this->repository->find($id)) {
            throw new EntityNotFoundException('Нет такого сезона???!!!!!!!!!!.');
        }
        return $uchasgoda;
    }

    public function allOfGoda(string $goda): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'u.id',
                'u.goda_id',
                'u.uchastie_id',
                'u.koltochek',
                'u.gruppa',

            '(SELECT COUNT(*) FROM paseka_sezon_tochkas t WHERE t.uchasgoda_id = u.id) AS koles'
            // '(
            //     SELECT COUNT(ms.member_id)
            //     FROM work_projects_project_memberships ms
            //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
            //     WHERE md.department_id = d.id AND ms.materi_id = :materi
            // ) AS members_count'
            )
            ->from('paseka_sezons_uchasgodas', 'u')
            ->andWhere('u.goda_id = :godas')
            ->setParameter(':godas', $goda)
            ->orderBy('gruppa')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'u.id',
                'u.goda_id ',
                'u.uchastie_id',
                'u.koltochek',
                'u.gruppa',
                'g.sezon as sezon',
                't.gruppa as grtochka',
                't.kolwz as kolwz',
                't.name as name'


//                '(SELECT COUNT(*) FROM paseka_sezon_tochkas t WHERE t.gruppa = s.id) AS linias'
            )
            ->from('paseka_sezons_uchasgodas', 'u')
            ->innerJoin('u', 'paseka_sezons_godas', 'g', 'g.id = u.goda_id')
            ->innerJoin('u', 'paseka_sezon_tochkas', 't', 't.uchasgoda_id = u.id')
            ->orderBy('sezon')
            ->orderBy('grtochka')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function allTochok(string $uchasgoda): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'u.id',
                'u.goda_id ',
                'u.uchastie_id',
                'u.koltochek',
                'u.gruppa',
                'g.sezon as sezon',
                't.gruppa as grtochka',
                't.kolwz as kolwz',
                't.name as name'

//                '(SELECT COUNT(*) FROM paseka_sezon_tochkas t WHERE t.gruppa = s.id) AS linias'
            )
            ->from('paseka_sezons_uchasgodas', 'u')
            ->innerJoin('u', 'paseka_sezons_godas', 'g', 'g.id = u.goda_id')
            ->innerJoin('u', 'paseka_sezon_tochkas', 't', 't.uchasgoda_id = u.id')
            ->andWhere('u.id = :ids')
            ->setParameter(':ids', $uchasgoda)
            ->orderBy('grtochka')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

//    public function allOfUchasGoda(string $uchastie): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'p.id AS project_id',
//                'p.name AS project_name',
//                'd.id AS department_id',
//                'd.name AS department_name'
//            )
//            ->from('paseka_sezons_uchasgodas', 'u')
//            ->innerJoin('ms', 'work_projects_project_membership_departments', 'msd', 'ms.id = msd.membership_id')
//            ->innerJoin('msd', 'work_projects_project_departments', 'd', 'msd.department_id = d.id')
//            ->innerJoin('d', 'work_projects_projects', 'p', 'd.project_id = p.id')
//            ->andWhere('ms.member_id = :member')
//            ->setParameter(':member', $member)
//            ->orderBy('p.sort')->addOrderBy('d.name')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }
}

<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Rasas\Linias;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class LiniaFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
	
	    public function getMaxSortLinia(string $rasa): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(l.sort_linia) AS m')
            ->from('paseka_rasa_linias', 'l')
			->andWhere('rasa_id = :rasas')
            ->setParameter(':rasas', $rasa)
            ->execute()->fetch()['m'];
    }
	
    public function listOfRasa(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name',
                'name_star',
                'title',
				'sort_linia'
            )
            ->from('paseka_rasa_linias')
            ->andWhere('rasa_id = :rasas')
            ->setParameter(':rasas', $rasa)
            ->orderBy('name')
            ->orderBy('name_star')
            ->orderBy('title')
			->orderBy('sort_linia')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function allOfRasa(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.name',
                'l.name_star',
                'l.title',
                'l.sort_linia',
                '(SELECT COUNT(*) FROM paseka_rasa_linia_nomers n WHERE n.linia_id = l.id) AS nomers'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('paseka_rasa_linias', 'l')
            ->andWhere('rasa_id = :rasas')
            ->setParameter(':rasas', $rasa)
            ->orderBy('name')
            ->orderBy('name_star')
            ->orderBy('title')
			->orderBy('sort_linia')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
		
	public function allOfRasLin(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.name',
                'l.name_star',
                'l.title',
				'l.sort_linia',
				'n.sort_nomer as sort_nomer',
				'n.name_star as nomers',
				'n.name_star as nomers'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('paseka_rasa_linias', 'l')
            ->andWhere('rasa_id = :rasas')
            ->setParameter(':rasas', $rasa)
->innerJoin('l', 'paseka_rasa_linia_nomers', 'n', 'n.linia_id = l.id')
            ->orderBy('name')
            ->orderBy('name_star')
            ->orderBy('title')
			->orderBy('sort_linia')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
	

    }
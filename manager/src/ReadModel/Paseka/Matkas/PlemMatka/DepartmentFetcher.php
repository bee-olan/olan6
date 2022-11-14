<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Matkas\PlemMatka;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class DepartmentFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function listOfPlemMatka(string $plemmatka): array
    {

        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('paseka_matkas_plemmatka_departments')
            ->andWhere('plemmatka_id = :plemmatka')
            ->setParameter(':plemmatka', $plemmatka)
            ->orderBy('name')
            ->execute();
        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function allOfPlemMatka(string $plemmatka): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.name'
//                ,
//                '(
//                    SELECT COUNT(ms.uchastie_id)
//                    FROM paseka_matkas_plemmatka_uchasniks ms
//                    INNER JOIN paseka_matkas_plemmatka_uchasnik_departments md ON ms.id = md.uchasnik_id
//                    WHERE md.department_id = d.id AND ms.plemmatka_id = :plemmatka
//                ) AS uchasties_count'
            )
            ->from('paseka_matkas_plemmatka_departments', 'd')
            ->andWhere('plemmatka_id = :plemmatka')
            ->setParameter(':plemmatka', $plemmatka)
            ->orderBy('name')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function allOfUchastnik(string $uchastie): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'p.id AS plemmatka_id',
                'p.name AS plemmatka_name',
                'd.id AS department_id',
                'd.name AS department_name'
            )
         //   ->from('paseka_matkas_plemmatka_uchasniks', 'ms')
//            ->innerJoin('ms', 'paseka_matkas_plemmatka_uchasnik_departments', 'msd', 'ms.id = msd.uchasnik_id')
            ->innerJoin('msd', 'paseka_matkas_plemmatka_departments', 'd', 'msd.department_id = d.id')
            ->innerJoin('d', 'paseka_matkas_plemmatkas', 'p', 'd.plemmatka_id = p.id')
            ->andWhere('ms.uchastie_id = :uchastie')
            ->setParameter(':uchastie', $uchastie)
            ->orderBy('p.sort')->addOrderBy('d.name')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}

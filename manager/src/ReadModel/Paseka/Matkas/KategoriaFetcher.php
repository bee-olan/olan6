<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Matkas;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class KategoriaFetcher
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
                'name'
            )
            ->from('paseka_matkas_sparings')
           // ->orderBy('nomer')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function allList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('paseka_matkas_kategorias')
            ->orderBy('name')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'r.id',
                'r.name',
                'r.permissions'
//                ,
//                '(SELECT COUNT(*) FROM paseka_matkas_plemmatka_uchastnik_kategorias m WHERE m.kategoria_id = r.id) AS uchastniks_count'
            )
            ->from('paseka_matkas_kategorias', 'r')
            ->orderBy('name')
            ->execute();

        return array_map(static function (array $kategoria) {
            return array_replace($kategoria, [
                'permissions' => json_decode($kategoria['permissions'], true)
            ]);
        }, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }
}


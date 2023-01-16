<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Sezons\Godas;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class GodaFetcher
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
                'sezon'
            )
            ->from('paseka_sezons_godas')
            ->orderBy('sezon')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

	    public function getMaxGod(): int
        {
            return (int)$this->connection->createQueryBuilder()
                ->select('MAX(s.god) AS m')
                ->from('paseka_sezons_godas', 's')
                ->execute()->fetch()['m'];
        }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                's.id',
                's.god',
                's.sezon'
            // ,
            // '(SELECT COUNT(*) FROM sait_u4astniks_u4astniks m WHERE m.godd_id = g.id) AS u4astniks'
            )
            ->from('paseka_sezons_godas', 's')
            ->orderBy('god')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

}
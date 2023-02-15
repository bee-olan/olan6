<?php

declare(strict_types=1);

namespace App\ReadModel\Mesto;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class OkrugFetcher
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
            ->from('mesto_okrugs')
            ->orderBy('name')
            ->execute();

            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'g.id',
                'g.name',
				'g.nomer',
                '(SELECT COUNT(*) FROM mesto_okrug_oblasts o WHERE o.okrug_id = g.id) AS oblasts'
            )
            ->from('mesto_okrugs', 'g')
            ->orderBy('name')
			->orderBy('nomer')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}

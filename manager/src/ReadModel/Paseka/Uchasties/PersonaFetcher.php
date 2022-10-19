<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Uchasties;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class PersonaFetcher
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
                'nomer'               
            )
            ->from('paseka_uchasties_personas')
            ->orderBy('nomer')
            ->execute();

            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function exists(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('paseka_uchasties_personas')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }
	
	   public function allPers(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'p.nomer'
                // ,
                // '(SELECT COUNT(*) FROM sait_u4astniks_u4astniks m WHERE m.godd_id = g.id) AS u4astniks'
            )
            ->from('paseka_uchasties_personas', 'p')
            ->orderBy('nomer')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'g.id',
                'g.nomer'
                // ,
                // '(SELECT COUNT(*) FROM sait_u4astniks_u4astniks m WHERE m.godd_id = g.id) AS u4astniks'
            )
            ->from('paseka_uchasties_personas', 'g')
            ->orderBy('nomer')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}

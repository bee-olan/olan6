<?php

declare(strict_types=1);

namespace App\ReadModel\Mesto\InfaMesto;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class MestoNomerFetcher
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
                'raion_id',
                'nomer'               
            )
            ->from('mesto_mestonomers')
            ->orderBy('nomer')
            ->execute();

            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function exists(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('mesto_mestonomers')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }
	
	   public function allMestNom(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'm.raion_id',
                'm.nomer AS mestonomer'
            )
            ->from('mesto_mestonomers', 'm')
            ->orderBy('nomer')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'm.id',
                'm.nomer AS mestonomer'

            )
            ->from('mesto_mestonomers', 'm')
            ->orderBy('nomer')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}

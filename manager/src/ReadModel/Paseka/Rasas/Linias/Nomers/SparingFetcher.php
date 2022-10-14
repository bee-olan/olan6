<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Rasas\Linias\Nomers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class SparingFetcher
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
            ->from('paseka_rasa_linia_nomer_sparings')
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
                'g.title' ,
                '(SELECT COUNT(*) FROM paseka_rasa_linia_nomers n WHERE n.sparing_id = g.id) AS nomers'
            )
            ->from('paseka_rasa_linia_nomer_sparings', 'g')
            ->orderBy('name')
			->orderBy('title')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}

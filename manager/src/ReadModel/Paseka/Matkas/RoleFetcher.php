<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Matkas;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class RoleFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function allList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('paseka_matkas_roles')
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
                'r.permissions',
                '(SELECT COUNT(*) FROM paseka_matkas_plemmatka_uchastnik_roles m WHERE m.role_id = r.id) AS uchastniks_count'
            )
            ->from('paseka_matkas_roles', 'r')
            ->orderBy('name')
            ->execute();

        return array_map(static function (array $role) {
            return array_replace($role, [
                'permissions' => json_decode($role['permissions'], true)
            ]);
        }, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }
}


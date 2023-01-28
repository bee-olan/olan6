<?php

declare(strict_types=1);

namespace App\DataFixtures\Kategorias;

use App\Model\Paseka\Entity\Matkas\Kategoria\Kategoria;
use App\Model\Paseka\Entity\Matkas\Kategoria\Id;
use App\Model\Paseka\Entity\Matkas\Kategoria\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class KategoriaFixture extends Fixture
{
    public const ELI1 = 'э';
    public const BRE1 = 'б';
    public const IO1 = 'и';
    public const ADA1 = 'а';

    public function load(ObjectManager $manager): void
    {
        $io = $this->createKategoria('и', [
            Permission::KATEGORIA_I_O,
            Permission::KATEGORIA_F_0,
            Permission::KATEGORIA_TRUT_SELEK

        ]);
        $manager->persist($io);
        $this->setReference(self::IO1, $io);
////////////////////////////////////////////////////////////////
        $eli = $this->createKategoria('э', [
            Permission::KATEGORIA_DOKUM,
            Permission::KATEGORIA_F_0,

        ]);
        $manager->persist($eli);
        $this->setReference(self::ELI1, $eli);
///////////////////////////////
        $bre = $this->createKategoria('б', [
            Permission::KATEGORIA_NET_DOKUM,
            Permission::KATEGORIA_F_1,
            Permission::KATEGORIA_TRUT_95,
        ]);
        $manager->persist($bre);
        $this->setReference(self::BRE1, $bre);

        /////////////////////////////////
        $ada = $this->createKategoria('а', [
            Permission::KATEGORIA_F_2,
            Permission::KATEGORIA_TRUT_90,
            Permission::KATEGORIA_TRUT_NET,
        ]);
        $manager->persist($ada);
        $this->setReference(self::ADA1, $ada);

        $manager->flush();
    }



    private function createKategoria(string $name, array $permissions): Kategoria
    {
        return new Kategoria(
            Id::next(),
            $name,
            $permissions
        );
    }
}

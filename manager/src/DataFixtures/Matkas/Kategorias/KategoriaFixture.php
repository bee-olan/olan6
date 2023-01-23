<?php


namespace App\DataFixtures\Matkas\Kategorias;

use App\Model\Paseka\Entity\Matkas\Kategoria\Kategoria;
use App\Model\Paseka\Entity\Matkas\Kategoria\Id;
use App\Model\Paseka\Entity\Matkas\Kategoria\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class KategoriaFixture extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        $bre = $this->createKategoria('Бре', [
            Permission::KATEGORIA_NET_DOKUM,
            Permission::KATEGORIA_F_1,
        ]);

        $manager->persist($bre);

        $eli = $this->createKategoria('Эли', [
            Permission::KATEGORIA_DOKUM,
            Permission::KATEGORIA_F_0,
        ]);
        $manager->persist($eli);

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
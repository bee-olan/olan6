<?php


namespace App\DataFixtures\Uchasties;

use App\Model\Paseka\Entity\Uchasties\Group\Group;
use App\Model\Paseka\Entity\Uchasties\Group\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class GrupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $grup = new Group(
            Id::next(),
            'Матководы'
        );
        $manager->persist($grup);

        $grup = new Group(
            Id::next(),
            'Пчеловоды'
        );
        $manager->persist($grup);

        $grup = new Group(
            Id::next(),
            'Пчело-Матководы'
        );
        $manager->persist($grup);

        $grup = new Group(
            Id::next(),
            'Наблюдатели'
        );
        $manager->persist($grup);

    $manager->flush();
    }

}
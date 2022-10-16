<?php


namespace App\DataFixtures\Rasas\Sparing;

use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Sparings\Sparing;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Sparings\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class SparingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sparing= new Sparing(
            Id::next(),
            'ио',
            'Искуственное'
        );
    $manager->persist($sparing);

        $sparing = new Sparing(
            Id::next(),
            'ос',
            'Островная'
        );
        $manager->persist($sparing);

        $sparing = new Sparing(
            Id::next(),
            'тф-90',
            'трутневый фон 90%'
        );
        $manager->persist($sparing);

        $sparing = new Sparing(
            Id::next(),
            'тф-60',
            'трутневый фон 60%'
        );
        $manager->persist($sparing);

        $sparing = new Sparing(
            Id::next(),
            'тф-40',
            'трутневый фон 40%'
        );
        $manager->persist($sparing);

        $sparing = new Sparing(
            Id::next(),
            'тф-бк',
            'трутневый фон без контроля'
        );
        $manager->persist($sparing);

    $manager->flush();
    }

}
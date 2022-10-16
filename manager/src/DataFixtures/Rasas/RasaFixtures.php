<?php


namespace App\DataFixtures\Rasas;

use App\Model\Paseka\Entity\Rasas\Rasa;
use App\Model\Paseka\Entity\Rasas\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class RasaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rasa = new Rasa(
            Id::next(),
            'Ср',
            'Среднерусская'
        );
    $manager->persist($rasa);

        $rasa = new Rasa(
            Id::next(),
            'Кр',
            'Карника'
        );
        $manager->persist($rasa);

        $rasa = new Rasa(
            Id::next(),
            'Ит',
            'Итальянка'
        );
        $manager->persist($rasa);

    $manager->flush();
    }

}
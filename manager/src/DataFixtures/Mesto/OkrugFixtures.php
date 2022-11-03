<?php


namespace App\DataFixtures\Mesto;

//use App\Model\Paseka\Entity\Rasas\Rasa;
//use App\Model\Paseka\Entity\Rasas\Id;

use App\Model\Mesto\Entity\Okrugs\Okrug;
use App\Model\Mesto\Entity\Okrugs\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class OkrugFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $okrug = new Okrug(
            Id::next(),
            'Центральный округ',
            '1'
        );
    $manager->persist($okrug);

        $okrug = new Okrug(
            Id::next(),
            'Северо-Западный',
            '2'
        );
        $manager->persist($okrug);

        $okrug = new Okrug(
            Id::next(),
            'Южный',
            '3'
        );
        $manager->persist($okrug);

        $okrug = new Okrug(
            Id::next(),
            'Приволжский',
            '4'
        );
        $manager->persist($okrug);

        $okrug = new Okrug(
            Id::next(),
            'Уральский',
            '5'
        );
        $manager->persist($okrug);

        $okrug = new Okrug(
            Id::next(),
            'Сибирский',
            '6'
        );
        $manager->persist($okrug);

        $okrug = new Okrug(
            Id::next(),
            'Северо-Кавказский',
            '7'
        );
        $manager->persist($okrug);

        $okrug = new Okrug(
            Id::next(),
            'Дальневосточный',
            '8'
        );
        $manager->persist($okrug);

        $okrug = new Okrug(
            Id::next(),
            'Крымский федеральный округ',
            '9'
        );
        $manager->persist($okrug);



    $manager->flush();
    }

}
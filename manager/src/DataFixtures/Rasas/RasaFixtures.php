<?php


namespace App\DataFixtures\Rasas;

use App\Model\Paseka\Entity\Rasas\Rasa;
use App\Model\Paseka\Entity\Rasas\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class RasaFixtures extends Fixture
{
    public const REFERENCE_SREDRUSS= 'rasas_rasa_sredruss';
    public const REFERENCE_KARNIK= 'rasas_rasa_karnik';
    public const REFERENCE_ITALL= 'rasas_rasa_itall';

    public function load(ObjectManager $manager): void
    {
        $sredruss = new Rasa(
            Id::next(),
            'Ср',
            'Среднерусская'
        );
        $manager->persist($sredruss);
        $this->setReference(self::REFERENCE_SREDRUSS, $sredruss);

        $karnik = new Rasa(
            Id::next(),
            'Кр',
            'Карника'
        );
        $manager->persist($karnik);
        $this->setReference(self::REFERENCE_KARNIK, $karnik);

        $itall = new Rasa(
            Id::next(),
            'Ит',
            'Итальянка'
        );
        $manager->persist($itall);
        $this->setReference(self::REFERENCE_ITALL, $itall);

    $manager->flush();
    }

}
<?php


namespace App\DataFixtures\Rasas;


use App\Model\Paseka\Entity\Rasas\Linias\Linia;
use App\Model\Paseka\Entity\Rasas\Linias\Id;
use App\Model\Paseka\Entity\Rasas\Rasa;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LiniaFixtures extends Fixture implements DependentFixtureInterface
{

    public const REFERENCE_SR_1= 'rasas_rasa_linia_sr_1';
    public const REFERENCE_SR_2= 'rasas_rasa_linia_sr_2';
    public const REFERENCE_KAR_1= 'rasas_rasa_linia_kar_1';
    public const REFERENCE_KAR_2= 'rasas_rasa_linia_kar_2';
    public const REFERENCE_IT_1= 'rasas_rasa_linia_it_1';
    public const REFERENCE_IT_2= 'rasas_rasa_linia_it_2';

    public function load(ObjectManager $manager): void
    {

        /**
         * @var Linia $name
         * @var Linia $nameStar
         * @var Linia $title
         * @var Linia $sortLinia
         */

        /**
         * @var Rasa $sredruss
         * @var Rasa $karnik
         * @var Rasa $itall
         */
        $sredruss = $this->getReference(RasaFixtures::REFERENCE_SREDRUSS);
        $karnik = $this->getReference(RasaFixtures::REFERENCE_KARNIK);
        $itall = $this->getReference(RasaFixtures::REFERENCE_ITALL);
//

        $sredruss_1 = $this->createLinia($sredruss, $name="л-1", $nameStar="1 запись о линии для Ср",
                                    $title="Ср_л-1", $sortLinia = 1);
        $manager->persist($sredruss_1);
        $this->setReference(self::REFERENCE_SR_1, $sredruss_1);

        $sredruss_2 = $this->createLinia($sredruss, $name="л-2", $nameStar="2 запись о линии для Ср",
                                    $title="Ср_л-2", $sortLinia = 2);
        $manager->persist($sredruss_2);
        $this->setReference(self::REFERENCE_SR_2, $sredruss_2);
////////////////////////////////////////////////////////////////////

        $karnik_1 = $this->createLinia($karnik, $name="л-1", $nameStar="1 запись о линии для Кр",
            $title="Кр_л-1", $sortLinia = 1);
        $manager->persist($karnik_1);
         $this->setReference(self::REFERENCE_KAR_1, $karnik_1);

        $karnik_2 = $this->createLinia($karnik, $name="л-2", $nameStar="2 запись о линии для Кр",
            $title="Кр_л-2", $sortLinia = 2);
        $manager->persist($karnik_2);
        $this->setReference(self::REFERENCE_KAR_2, $karnik_2);
        ////////////////////////////////////

        $itall_1 = $this->createLinia($itall, $name="л-1", $nameStar="1 запись о линии для Ит",
            $title="Ит_л-1", $sortLinia = 1);
        $manager->persist($itall_1);
        $this->setReference(self::REFERENCE_IT_1, $itall_1);

        $itall_2 = $this->createLinia($itall, $name="л-2", $nameStar="2 запись о линии для Ит",
            $title="Ит_л-2", $sortLinia = 2);
        $manager->persist($itall_2);
        $this->setReference(self::REFERENCE_IT_2, $itall_2);


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RasaFixtures::class,
        ];
    }

    private function createLinia( Rasa $rasa, string $name, string $nameStar, string $title, int $sortLinia): Linia
    {

        return new Linia(
            $rasa,
            Id::next(),
            $name,
            $nameStar,
            $title,
            $sortLinia
        );
    }
}
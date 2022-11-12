<?php


namespace App\DataFixtures\Rasas;


use App\Model\Paseka\Entity\Rasas\Linias\Linia;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Nomer;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class NomerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        /**
         * @var Nomer $name
         * @var Nomer $nameStar
         * @var Nomer $title
         * @var Nomer $sortLinia
         */

        /**
         * @var Linia $sredruss_1
         * @var Linia $sredruss_2
         * @var Linia $karnik_1
         * @var Linia $karnik_2
         * @var Linia $itall_1
         * @var Linia $itall_2
         */
        $sredruss_1 = $this->getReference(LiniaFixtures::REFERENCE_SR_1);
        $sredruss_2 = $this->getReference(LiniaFixtures::REFERENCE_SR_2);

        $karnik_1 = $this->getReference(LiniaFixtures::REFERENCE_KAR_1);
        $karnik_2 = $this->getReference(LiniaFixtures::REFERENCE_KAR_2);

        $itall_1 = $this->getReference(LiniaFixtures::REFERENCE_IT_1);
        $itall_2 = $this->getReference(LiniaFixtures::REFERENCE_IT_2);

        $nomer = $this->createLinia($sredruss_1, $name="н-1", $nameStar="1 запись о номере для Ср_л-1",
            $title="Ср_л-1_н-1", $sortLinia = 1);
        $manager->persist($nomer);

        $nomer = $this->createLinia($sredruss_1, $name="н-2", $nameStar="2 запись о номере для Ср_л-1",
            $title="Ср_л-1_н-2", $sortLinia = 2);
        $manager->persist($nomer);

        $nomer = $this->createLinia($sredruss_2, $name="н-1", $nameStar="1 запись о номере для Ср_л-2",
            $title="Ср_л-2_н-1", $sortLinia = 1);
        $manager->persist($nomer);

        $nomer = $this->createLinia($sredruss_2, $name="н-2", $nameStar="2 запись о номере для Ср_л-2",
            $title="Ср_л-2_н-2", $sortLinia = 2);
        $manager->persist($nomer);


        $nomer = $this->createLinia($itall_1, $name="н-1", $nameStar="1 запись о номере для Ит_л-1",
            $title="Ит_л-1_н-1", $sortLinia = 1);
        $manager->persist($nomer);

        $nomer = $this->createLinia($itall_2, $name="н-1", $nameStar="1 запись о номере для Ит_л-2",
            $title="Ит_л-2_н-1", $sortLinia = 1);
        $manager->persist($nomer);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LiniaFixtures::class,
        ];
    }

    private function createLinia( Linia $linia, string $name, string $nameStar, string $title, int $sortLinia): Nomer
    {

        return new Nomer(
            $linia,
            Id::next(),
            $name,
            $nameStar,
            $title,
            $sortLinia
        );
    }
}
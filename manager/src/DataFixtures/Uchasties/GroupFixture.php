<?php


namespace App\DataFixtures\Uchasties;


use App\Model\Paseka\Entity\Uchasties\Group\Group;
use App\Model\Paseka\Entity\Uchasties\Group\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class GroupFixture extends Fixture
{
    public const REFERENCE_MATKOV = 'work_member_group_staff';
    public const REFERENCE_PCHEL = 'work_member_group_customers';
    public const REFERENCE_PCHELMAT = 'work_member_group_staff';
    public const REFERENCE_NABLUD = 'work_member_group_customers';

    public function load(ObjectManager $manager): void
    {

        $matkov = new Group(
            Id::next(),
            'Матководы'
        );
        $manager->persist($matkov);
        $this->setReference(self::REFERENCE_MATKOV, $matkov);

        $pchel = new Group(
            Id::next(),
            'Пчеловоды'
        );
        $manager->persist($pchel);
        $this->setReference(self::REFERENCE_PCHEL, $pchel);

        $pchelmat = new Group(
            Id::next(),
            'Пчело-Матководы'
        );
        $manager->persist($pchelmat);
        $this->setReference(self::REFERENCE_PCHELMAT, $pchelmat);

        $nablud = new Group(
            Id::next(),
            'Наблюдатели'
        );
        $manager->persist($nablud);
        $this->setReference(self::REFERENCE_NABLUD, $nablud);

    $manager->flush();
    }

}
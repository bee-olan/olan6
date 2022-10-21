<?php


namespace App\DataFixtures\Uchasties;

use App\DataFixtures\UserFixture;

use App\Model\Paseka\Entity\Uchasties\Group\Group;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UchastieFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /**
         * @var User $admin
         * @var User $user
         */
        $admin = $this->getReference(UserFixture::REFERENCE_ADMIN);
        $user = $this->getReference(UserFixture::REFERENCE_USER);

        /**
         * @var Group $matkov
         * @var Group $pchel
         * @var Group $pchelmat
         * @var Group $nablud
         */
        $matkov = $this->getReference(GroupFixture::REFERENCE_MATKOV);
        $pchel = $this->getReference(GroupFixture::REFERENCE_PCHEL);
        $pchelmat = $this->getReference(GroupFixture::REFERENCE_PCHELMAT);
        $nablud = $this->getReference(GroupFixture::REFERENCE_NABLUD);

        $member = $this->createUchastie($admin, $matkov);
        $manager->persist($member);

        $member = $this->createUchastie($user, $pchel);
        $manager->persist($member);

        $member = $this->createUchastie($admin, $pchelmat);
        $manager->persist($member);

        $member = $this->createUchastie($user, $nablud);
        $manager->persist($member);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            GroupFixture::class,
        ];
    }

    private function createUchastie(User $user, Group $group): Uchastie
    {
        return new Uchastie(
            new Id($user->getId()->getValue()),
            $group,
            new Name(
                $user->getName()->getFirst(),
                $user->getName()->getLast()
            )
        );
    }

}
<?php


namespace App\DataFixtures\Uchasties;

use App\DataFixtures\UserFixture;


use App\Model\Paseka\Entity\Uchasties\Uchastie\Name;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Email;


use App\Model\User\Entity\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use App\Model\Paseka\Entity\Uchasties\Group\Group;

class UchastieFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /**
         * @var \DateTimeImmutable $date
         */

        /**
         * @var User $admin
         * @var User $user
         */
        $admin = $this->getReference(UserFixture::REFERENCE_ADMIN);
        $user = $this->getReference(UserFixture::REFERENCE_USER);

        /**
         * @var Group $makow
         * @var Group $pchel
         * @var Group $pchelmakow
         * @var Group $nablud
         */
        $makow = $this->getReference(GroupFixture::REFERENCE_NADLUD);
        $pchel = $this->getReference(GroupFixture::REFERENCE_PCHEL);
//        $pchelmakow = $this->getReference(GroupFixture::REFERENCE_PCHELMATKOW);
//        $nablud = $this->getReference(GroupFixture::REFERENCE_NADLUD);

        $uchastie = $this->createUchastie($admin, $makow, $nike="Ник 1");
        $manager->persist($uchastie);

        $uchastie = $this->createUchastie($user, $pchel, $nike="Ник 2");
        $manager->persist($uchastie);

//        $uchastie = $this->createUchastie($admin, $pchelmakow, $nike="Ник 3");
//        $manager->persist($uchastie);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            GroupFixture::class,
        ];
    }

    private function createUchastie(User $user, Group $group, string $nike ): Uchastie
    {
        return new Uchastie(
            new Id($user->getId()->getValue()),
            new \DateTimeImmutable(),
            $group,
            new Name(
                $user->getName()->getFirst(),
                $user->getName()->getLast(),
                $nike
            ),
            new Email($user->getEmail() ? $user->getEmail()->getValue() : null)



        );
    }
}
//,
// new UchKak($user->getUchkak() ? $user->getUchkak()->getValue() : null)
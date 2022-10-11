<?php

namespace App\DataFixtures;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Name;
use App\Model\User\Entity\User\Role;
use App\Model\User\Entity\User\UchKak;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\Id;
use App\Model\User\Service\PasswordHasher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    private $hasher;

    public function __construct(PasswordHasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $hash = $this->hasher->hash('password');

        $user = User::signUpByEmail(
            Id::next(),
            new \DateTimeImmutable(),
            new Name('Ol', 'An'),
            new Email('admin@app.test'),
            $hash,
            'token'
        );
        $user->confirmSignUp();
        $user->changeRole(Role::admin());
        $user->changeUchKak(UchKak::pchmat());
        $manager->persist($user);

        $user1 = User::signUpByEmail(
            Id::next(),
            new \DateTimeImmutable(),
            new Name('Ольга', 'Клим'),
            new Email('user@app.test'),
            $hash,
            'token'
        );

        $user1->confirmSignUp();
//        $user1->changeRole(Role::user());
        $user1->changeUchKak(UchKak::matko());
        $manager->persist($user1);
 ///////////
        $user2 = User::signUpByEmail(
            Id::next(),
            new \DateTimeImmutable(),
            new Name('Pchel', '1'),
            new Email('pchel1@app.test'),
            $hash,
            'token'
        );

        $user2->confirmSignUp();
//        $user1->changeRole(Role::user());
//        $user2->changeUchKak(UchKak::matko());
        $manager->persist($user2);

        $manager->flush();
    }
}

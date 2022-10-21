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
    public const REFERENCE_ADMIN = 'user_user_admin';
    public const REFERENCE_USER = 'user_user_user';

    private $hasher;

    public function __construct(PasswordHasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $hash = $this->hasher->hash('password');

        $admin = User::signUpByEmail(
            Id::next(),
            new \DateTimeImmutable(),
            new Name('Ol', 'An'),
            new Email('admin@app.test'),
            $hash,
            'token'
        );
        $admin->confirmSignUp();
        $admin->changeRole(Role::admin());
        $admin->changeUchKak(UchKak::pchmat());
        $manager->persist($admin);

        $this->setReference(self::REFERENCE_ADMIN, $admin);

        $user = User::signUpByEmail(
            Id::next(),
            new \DateTimeImmutable(),
            new Name('Ольга', 'Клим'),
            new Email('user@app.test'),
            $hash,
            'token'
        );

        $user->confirmSignUp();
//        $user->changeRole(Role::user());
        $user->changeUchKak(UchKak::matko());
        $manager->persist($user);
        $this->setReference(self::REFERENCE_USER, $user);
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

        $this->setReference(self::REFERENCE_USER, $user2);

        $manager->flush();
    }
}

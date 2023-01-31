<?php

declare(strict_types=1);
namespace App\DataFixtures\Matkas\Roles;

use App\Model\Paseka\Entity\Matkas\Role\Permission;
use App\Model\Paseka\Entity\Matkas\Role\Role;
use App\Model\Paseka\Entity\Matkas\Role\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixture extends Fixture
{

//    public const MANAGE_PLEMMATKA_UCHASTIES = 'Участие в регистрации ПлемМаток';
//    public const VIEW_CHILDMATKAS = 'Смотреть ДочьМаток';
//    public const ZAKAZ_CHILDMATKAS = 'Заказывать   ДочьМаток';
//    public const MANAGE_CHILDMATKAS_UCHASTIES = 'Участие в регистрации ДочьМаток';
    public const REFERENCE_MANAGER = 'plemmatka_role_manager';
    public const REFERENCE_GUEST = 'plemmatka_role_guest';
    public const REFERENCE_ADMIN = 'plemmatka_role_admin';
    public const REFERENCE_MATKOVOD = 'plemmatka_role_matkovod';

    public function load(ObjectManager $manager): void
    {
        $guest = $this->createRole('Гость', [
            Permission::VIEW_CHILDMATKAS,
        ]);
        $manager->persist($guest);
        $this->setReference(self::REFERENCE_GUEST, $guest);


        $manage = $this->createRole('Куратор', [
            Permission::MANAGE_PLEMMATKA_UCHASTIES,
            Permission::VIEW_CHILDMATKAS,
            Permission::MANAGE_CHILDMATKAS_UCHASTIES,
        ]);
        $manager->persist($manage);
        $this->setReference(self::REFERENCE_MANAGER, $manage);

        $admin = $this->createRole('Админ', [
            Permission::MANAGE_PLEMMATKA_UCHASTIES,
            Permission::VIEW_CHILDMATKAS,
            Permission::MANAGE_CHILDMATKAS_UCHASTIES,
            Permission::ADMIN_MATKA,
        ]);
        $manager->persist($admin);
        $this->setReference(self::REFERENCE_ADMIN, $admin);

        $matka = $this->createRole('Матковод', [
            Permission::MANAGE_PLEMMATKA_UCHASTIES,
            Permission::VIEW_CHILDMATKAS,
            Permission::MANAGE_CHILDMATKAS_UCHASTIES,

        ]);
        $manager->persist($matka);
        $this->setReference(self::REFERENCE_MANAGER, $matka);

        $manager->flush();
    }

    private function createRole(string $name, array $permissions): Role
    {
        return new Role(
            Id::next(),
            $name,
            $permissions
        );
    }

}




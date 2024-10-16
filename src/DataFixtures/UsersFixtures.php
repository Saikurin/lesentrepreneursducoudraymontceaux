<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('siklitheo@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(password_hash('siklitheo', PASSWORD_DEFAULT));
        $manager->persist($user);

        $manager->flush();
    }
}

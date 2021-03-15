<?php

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture

{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $role = new Role;
        $role->setLibelle('ROLE_ADMIN');
        $manager->persist($role);

        $role1 = new Role;
        $role1->setLibelle('ROLE_CLIENT');
        $manager->persist($role1);

        $role2 = new Role;
        $role2->setLibelle('ROLE_GERANT_RESTO');
        $manager->persist($role2);

        $user = new User;
        $user->setUsername('admin');
        $user->setNomComplet('Sara Ba');
        $user->setTelephone(779744347);
        $user->setRole($role);
        $user->setEmail('sara271295@gmail.com');
        $password = $this->encoder->encodePassword($user, 'admin123');
        $user->setPassword($password);

        $manager->persist($user);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // ADMIN
        $admin = new User();
        $admin->setUsername("ADMIN")
            ->setEmail("admin@localhost")
            ->setPassword($this->passwordEncoder->encodePassword($admin, 'admin'))
            ->setRoles(["ROLE_ADMIN"]);

        $manager->persist($admin);

        // TECHNICIAN
        $tech = new User();
        $tech->setUsername("TECHNICIAN")
            ->setEmail("tech@localhost")
            ->setPassword($this->passwordEncoder->encodePassword($tech, 'tech'))
            ->setRoles(["ROLE_TECHNICIAN"]);

        $manager->persist($tech);

        // CLIENT
        $client = new User();
        $client->setUsername("CLIENT")
            ->setEmail("client@localhost")
            ->setPassword($this->passwordEncoder->encodePassword($client, 'client'))
            ->setRoles(["ROLE_CLIENT"]);

        $manager->persist($client);

        $manager->flush();
    }
}

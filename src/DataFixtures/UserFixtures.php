<?php

namespace App\DataFixtures;

use App\Entity\Partygoer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $fdp)
    {
        $this->encoder = $fdp;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 11; $i++) {
            $partygoer = new Partygoer();
            $user = new User();

            $partygoer->setUser($user);
            $partygoer->setFirstname($faker->firstName());
            $partygoer->setLastname($faker->lastName());
            $partygoer->setBirthdate($faker->dateTime());
            $partygoer->setPhone('0645953115');
            $partygoer->setPresentation($faker->text(300));
            
            $user->setPartygoer($partygoer);
            $user->setRoles(['ROLE_USER']);
            $user->setEmail('user' . $i . '@hbo.com');
            $user->setPassword($this->encoder->encodePassword(
                $user,
                'user'
            ));

            $manager->persist($partygoer);
            $manager->persist($user);

            $this->addReference('planner_' . $i, $partygoer);
        }

        $manager->flush();
    }
}

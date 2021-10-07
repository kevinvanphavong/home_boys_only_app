<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setBirthdate($faker->dateTime());
            $user->setEmail('user' . $i . '@hbo.com');
            $user->setPhone('0645953115');
            $user->setRoles(['ROLE_USER']);
            $user->setPresentation($faker->text(300));
            $user->setPassword($this->encoder->encodePassword(
                $user,
                'user'
            ));
            $manager->persist($user);

            $this->addReference('planner_' . $i, $user);
        }

        $manager->flush();
    }
}
